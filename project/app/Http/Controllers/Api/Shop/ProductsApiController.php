<?php

/**
 * Products short summary.
 *
 * Products description.
 *
 * @version 1.0
 * @author 79523
 */
namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\ApiController;
use Aimeos\Shop\Facades\Shop;

class ProductsApiController extends ApiController
{
    public function getProducts(){
        foreach( app( 'config' )->get( 'shop.page.catalog-list' ) as $name )
		{
			$gg = Shop::get( $name )->getHeader();
			$gg = Shop::get( $name )->getBody();
		}
        $arr = ['name' => $gg];
        //$m = new \Aimeos\MShop\Product\Manager\Lists\Standard();
        return response()->json($arr);
    }
}
