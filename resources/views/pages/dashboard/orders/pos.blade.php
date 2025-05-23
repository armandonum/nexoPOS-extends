<?php
use Illuminate\Support\Facades\Gate;

?>
@extends( 'layout.dashboard-blank' )

@section( 'layout.dashboard.header' )
    @parent
    @yield( 'layout.dashboard.header.pos' )
    <style>
        .ofertas-activas-brillo {
            background-color: #fffacd; /* LemonChiffon */
            border: 1px solid #ffd700; /* Gold */
            padding: 10px;
            margin-bottom: 15px; /* Espacio opcional si se muestra encima de otros elementos */
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            color: #333;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            animation: pulse-animation 2s infinite;
        }

        @keyframes pulse-animation {
            0% { box-shadow: 0 0 5px rgba(255, 215, 0, 0.3); }
            50% { box-shadow: 0 0 15px rgba(255, 215, 0, 0.7); }
            100% { box-shadow: 0 0 5px rgba(255, 215, 0, 0.3); }
        }
    </style>
@endsection

@section( 'layout.dashboard.body' )
<div id="pos-app" class="h-full w-full relative">
    <div id="loader" class="top-0 anim-duration-500 fade-in-entrance left-0 absolute w-full z-50 h-full flex flex-col items-center justify-center">
        @if ( ns()->option->get( 'ns_store_square_logo', false ) )
        <img src="{{ ns()->option->get( 'ns_store_square_logo' ) }}" alt="POS">
        @else
        <img src="{{ asset( 'svg/nexopos-variant-1.svg' ) }}" class="w-32" alt="POS">
        @endif
        <p class="font-semibold py-2">{{ __( 'Loading...' ) }}</p>
    </div>
    <div id="disponibles" style="display: none;">
    </div>
    <ns-pos></ns-pos>
</div>
@endsection

@section( 'layout.dashboard.footer' )
    @parent
    @include( 'common.popups' )
    @vite([ 'resources/ts/pos-init.ts' ])
    <script>
        const nsShortcuts   =   <?php echo json_encode([
            'ns_pos_keyboard_cancel_order'      =>  ns()->option->get( 'ns_pos_keyboard_cancel_order' ),
            'ns_pos_keyboard_hold_order'        =>  ns()->option->get( 'ns_pos_keyboard_hold_order' ),
            'ns_pos_keyboard_create_customer'   =>  ns()->option->get( 'ns_pos_keyboard_create_customer' ),
            'ns_pos_keyboard_payment'           =>  ns()->option->get( 'ns_pos_keyboard_payment' ),
            'ns_pos_keyboard_shipping'          =>  ns()->option->get( 'ns_pos_keyboard_shipping' ),
            'ns_pos_keyboard_note'              =>  ns()->option->get( 'ns_pos_keyboard_note' ),
            'ns_pos_keyboard_order_type'        =>  ns()->option->get( 'ns_pos_keyboard_order_type' ),
            'ns_pos_keyboard_quick_search'      =>  ns()->option->get( 'ns_pos_keyboard_quick_search' ),
            'ns_pos_keyboard_toggle_merge'      =>  ns()->option->get( 'ns_pos_keyboard_toggle_merge' ),
            'ns_pos_amount_shortcut'            =>  ns()->option->get( 'ns_pos_amount_shortcut' ),
        ]);?>
    </script>
    <script>
    document.addEventListener( 'DOMContentLoaded', () => {
        POS.defineTypes(<?php echo json_encode( $orderTypes );?>);
        POS.defineOptions( <?php echo json_encode( $options );?>);
        POS.defineSettings({
            barcode_search          :   true,
            text_search             :   false,
            edit_purchase_price     :   <?php echo Gate::allows( 'nexopos.pos.edit-purchase-price' ) ? 'true' : 'false';?>,
            edit_settings           :   <?php echo Gate::allows( 'nexopos.pos.edit-settings' ) ? 'true' : 'false';?>,
            products_discount       :   <?php echo Gate::allows( 'nexopos.pos.products-discount' ) ? 'true' : 'false';?>,
            cart_discount           :   <?php echo Gate::allows( 'nexopos.pos.cart-discount' ) ? 'true' : 'false';?>,
            breadcrumb              :   [],
            products_queue          :   [],
            ns_pos_items_merge      :   <?php echo ns()->option->get( 'ns_pos_items_merge', 'no' ) === 'yes' ? 'true' : 'false';?>,
            unit_price_editable     :   <?php echo ns()->option->get( 'ns_pos_unit_price_ediable', 'yes' ) === 'yes' ? 'true' : 'false';?>,
            urls                    :   <?php echo json_encode( $urls );?>
        });

        POS.definedPaymentsType( <?php echo json_encode( $paymentTypes );?> );

        const ofertasActivasElement = document.getElementById('disponibles');
        const urlOfertasActivas = "{{ route('ofertas.activas.json') }}";

        if (ofertasActivasElement) {
            fetch(urlOfertasActivas)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errData => {
                            throw new Error(Respuesta de red no fue OK: ${response.statusText}. Mensaje del servidor: ${errData.message || (errData.error || 'No hay mensaje adicional')});
                        }).catch(() => {
                            throw new Error(Respuesta de red no fue OK: ${response.statusText}. No se pudo parsear la respuesta de error.);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.status === 'success') { 
                        ofertasActivasElement.textContent = 'Hay ofertas activas';
                        ofertasActivasElement.classList.add('ofertas-activas-brillo');
                        ofertasActivasElement.style.display = 'block'; 
                    } else {

                        ofertasActivasElement.style.display = 'none'; 
                        ofertasActivasElement.classList.remove('ofertas-activas-brillo'); 
                        if (data && data.message) {
                            console.info('Respuesta del servidor (ofertas): ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error al obtener ofertas activas:', error.message);
                    ofertasActivasElement.style.display = 'none';
                    ofertasActivasElement.classList.remove('ofertas-activas-brillo');
                });
        } else {
            console.warn('El elemento con ID "disponibles" no fue encontrado en el DOM.');
        }
    });

    /**
     * At the moment of the execution, the POS script
     * will be reset by a vue component to ensure everything is
     * working only when those component are loaded.
     */
    </script>
    @vite([ 'resources/ts/pos.ts' ])
@endsection