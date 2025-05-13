<template>
    <div class="ns-box">
        <div class="ns-box-header p-2 border-b flex justify-between items-center">
            <h3>{{ __('Ofertas Disponibles') }}</h3>
            <div>
                <!-- <ns-close-button @click="closePopup()"></ns-close-button> -->
                <ns-close-button @click="popup.reject()"></ns-close-button>
            </div>
        </div>
        <div class="ns-box-body p-4">
            <div v-if="offers.length === 0" class="text-center text-gray-500">
                {{ __('No active offers available...') }}
            </div>
            <div v-else class="space-y-2 max-h-96 overflow-y-auto">
                <div v-for="offer in offers" :key="offer.id"
                    class="border rounded p-3 flex justify-between items-center hover:bg-gray-100 cursor-pointer"
                    @click="selectOffer(offer)">
                    <div>
                        <h3 class="font-medium">{{ offer.name }}</h3>
                        <p class="text-sm text-gray-600">{{ offer.description }}</p>
                        <p class="text-sm text-gray-600">
                            {{ __('Valid until') }}: {{ formatDate(offer.end_date) }}
                        </p>
                    </div>
                    <span class="text-green-500 font-semibold">{{ offer.discount }}% {{ __('Off') }}</span>
                </div>
            </div>
        </div>
        <div class="ns-box-footer border-t p-2 flex justify-end">
            <ns-button @click="closePopup()" type="info">
                {{ __('Close') }}
            </ns-button>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { __ } from '~/libraries/lang';
import popupCloser from '~/libraries/popup-closer';
import popupResolver from '~/libraries/popup-resolver';
import nsCloseButton from '~/components/ns-close-button.vue';

export interface Offer {
    id: number;
    name: string;
    description: string;
    discount: number;
    end_date: string;
}

export default defineComponent({
    name: 'ns-pos-offers-popup',
    props: ['popup'],
    components: {
        nsCloseButton  // Registra el componente
    },
    data() {
        return {
            offers: [] as Offer[],
        };
    },
    methods: {
        __,
        popupCloser,
        popupResolver,
        formatDate(date: string) {
            return new Date(date).toLocaleDateString();
        },
        selectOffer(offer: any) {
            this.popup.resolve(offer);
        },
        closePopup() {
            this.popup.reject(false);
        },
    },
    mounted() {
        this.popupCloser();

        // Agregamos los datos de ejemplo
        this.offers = [
            {
                id: 1,
                name: 'Oferta de Verano',
                description: 'Descuento en productos seleccionados',
                discount: 20,
                end_date: '2025-06-30',
            },
            {
                id: 2,
                name: 'Fin de Semana Especial',
                description: 'Aplica a toda la tienda',
                discount: 15,
                end_date: '2025-05-20',
            },
        ];
    }
});
</script>