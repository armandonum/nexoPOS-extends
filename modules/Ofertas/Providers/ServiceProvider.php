<?php 
namespace Modules\Ofertas\Providers;

use Illuminate\Support\Facades\Log;

use App\Classes\Hook;
use App\Providers\AppServiceProvider;



class ServiceProvider extends AppServiceProvider
{


    public function register()
    {
        Log::info('ServiceProvider de MiModulo CARGADO');

        Hook::addFilter('ns-dashboard-menus', function ($menus) {
            $menus = array_insert_before( $menus, 'modules' , [
                'my-menus' => [
                    'label' =>  __('Ofertas'),
                    'href' => ns()->url('ofertas_list'),
               
                ],
                
             
            ]);
                return $menus;
            });
           
        }
}