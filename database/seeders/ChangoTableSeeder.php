<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\Chango;
use App\Models\Cliente;
use App\Models\Wonderlist;
use App\Models\Venta;

class ChangoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wonderlist::truncate(); // Evita duplicar datos

        $producto = new Wonderlist();
        $producto->marca = "Peñon del aguila";
        $producto->tipo = "Franbueza";
        $producto->precioCompra = 100;
        $producto->unidadCompra = "unidad";
        $producto->precioVenta = 170;
        $producto->precioPack = 1020;
        $producto->stock = 15;
        $producto->tipoCerveza = "artesanal";
        $producto->save();

        $producto = new Wonderlist();
        $producto->marca = "Peñon del aguila";
        $producto->tipo = "Arandano";
        $producto->precioCompra = 100;
        $producto->unidadCompra = "unidad";
        $producto->precioVenta = 170;
        $producto->precioPack = 1020;
        $producto->stock = 15;
        $producto->tipoCerveza = "artesanal";
        $producto->save();

        $producto = new Wonderlist();
        $producto->marca = "Peñon del aguila";
        $producto->tipo = "Sandia";
        $producto->precioCompra = 100;
        $producto->unidadCompra = "unidad";
        $producto->precioVenta = 170;
        $producto->precioPack = 1020;
        $producto->stock = 15;
        $producto->tipoCerveza = "artesanal";
        $producto->save();
        
        $producto = new Wonderlist();
        $producto->marca = "Imperial";
        $producto->tipo = "Roja";
        $producto->precioCompra = 1560;
        $producto->unidadCompra = "pack24";
        $producto->precioVenta = 100;
        $producto->precioPack = 600;
        $producto->stock = 24;
        $producto->tipoCerveza = "industrial";
        $producto->save();

        $producto = new Wonderlist();
        $producto->marca = "Imperial";
        $producto->tipo = "Negra";
        $producto->precioCompra = 1560;
        $producto->unidadCompra = "pack24";
        $producto->precioVenta = 100;
        $producto->precioPack = 600;
        $producto->stock = 24;
        $producto->tipoCerveza = "industrial";
        $producto->save();

        $producto = new Wonderlist();
        $producto->marca = "Brahma";
        $producto->tipo = "Rubia Lata 473";
        $producto->precioCompra = 560;
        $producto->unidadCompra = "sixpack";
        $producto->precioVenta = 100;
        $producto->precioPack = 600;
        $producto->stock = 24;
        $producto->tipoCerveza = "industrial";
        $producto->save();

        $producto = new Wonderlist();
        $producto->marca = "Brahma";
        $producto->tipo = "Rubia 1L";
        $producto->precioCompra = 1560;
        $producto->unidadCompra = "pack24";
        $producto->precioVenta = 100;
        $producto->precioPack = 600;
        $producto->stock = 24;
        $producto->tipoCerveza = "industrial";
        $producto->save();

        $producto = new Wonderlist();
        $producto->marca = "Tacuara";
        $producto->tipo = "Porter";
        $producto->precioCompra = 100;
        $producto->unidadCompra = "unidad";
        $producto->precioVenta = 160;
        $producto->precioPack = 1020;
        $producto->stock = 15;
        $producto->tipoCerveza = "artesanal";
        $producto->save();

        $producto = new Wonderlist();
        $producto->marca = "Tacuara";
        $producto->tipo = "Jim Morrison";
        $producto->precioCompra = 100;
        $producto->unidadCompra = "unidad";
        $producto->precioVenta = 160;
        $producto->precioPack = 1020;
        $producto->stock = 15;
        $producto->tipoCerveza = "artesanal";
        $producto->save();

        $producto = new Wonderlist();
        $producto->marca = "Barba roja";
        $producto->tipo = "Frutada";
        $producto->precioCompra = 100;
        $producto->unidadCompra = "unidad";
        $producto->precioVenta = 160;
        $producto->precioPack = 1020;
        $producto->stock = 15;
        $producto->tipoCerveza = "artesanal";
        $producto->save();

        $producto = new Wonderlist();
        $producto->marca = "Barba roja";
        $producto->tipo = "Lemon";
        $producto->precioCompra = 100;
        $producto->unidadCompra = "unidad";
        $producto->precioVenta = 160;
        $producto->precioPack = 1020;
        $producto->stock = 15;
        $producto->tipoCerveza = "artesanal";
        $producto->save();


        Cliente::truncate(); // Evita duplicar datos
        $cliente = new Cliente();
        $cliente->nombreCliente = "Cliente rapido";
        $cliente->save();

        $cliente = new Cliente();
        $cliente->nombreCliente = "Naiqui Gepataki";
        $cliente->contacto = "+54 126857461111";
        $cliente->contactoDos = "Instagram: Naiquillo";
        $cliente->lugar = "Rincon de milberg";
        $cliente->lugarDos = "No recuerdo la direccion";
        $cliente->save();

        $cliente = new Cliente();
        $cliente->nombreCliente = "Tedin";
        $cliente->contacto = "+54 126857461111";
        $cliente->contactoDos = "Desconocido";
        $cliente->lugar = "Tigre centro";
        $cliente->lugarDos = "Tedin 159, timbre 3";
        $cliente->save();
        
        Chango::truncate(); // Evita duplicar datos

        $chango = new Chango();
        $chango->cliente_id = 1;
        $chango->estadoVenta = "proceso";
        $chango->descuento = 100;
        $chango->save();

        $chango->wonderlist()->attach([1], ['cantidad' => 2,'subtotal' => 2356, 'unidades' => 'sixpack']);
        $chango->wonderlist()->attach([2], ['cantidad' => 5,'subtotal' => 1000, 'unidades' => 'unidad']);

        $chango = new Chango();
        $chango->cliente_id = 2;
        $chango->estadoVenta = "pendiente";
        $chango->descuento = 30;
        $chango->save();

        $chango->wonderlist()->attach([2], ['cantidad' => 1,'subtotal' => 50,'unidades' => 'unidad']);


        $venta = new Venta();
        $venta->nombreCliente = 'Naiqui';
        $venta->productosVendidos = '*Pack de artesanales <br> *Pack de milanesas';
        $venta->valorVenta = 300;
        $venta->lugar = 'Su casa';
        $venta->fecha = Carbon::now();
        $venta->save();

        $venta = new Venta();
        $venta->nombreCliente = 'Tedin';
        $venta->productosVendidos = '*Pack de imperial golden <br> *Pack de imperial ipa';
        $venta->valorVenta = 300;
        $venta->lugar = 'Tedin 159 piso 18';
        $venta->fecha = Carbon::now();
        $venta->save();

        $venta = new Venta();
        $venta->nombreCliente = 'Naiqui';
        $venta->productosVendidos = '<li>Peñon del aguila (Franbueza) -> 1</li><br><li>Peñon del aguila (Franbueza) -> 1</li><br><li>Peñon del aguila (Arandano) -> 1</li><br><li>Peñon del aguila (Sandia) -> 1</li><br><li>Barba roja (Frutada) -> 1</li><br><li>Barba roja (Lemon) -> 1</li><br><li>Imperial (Roja) -> 6</li><br><li>Imperial (Negra) -> 6</li><br><li>Brahma (Rubia Lata 473) -> 6</li><br><li>Brahma (Rubia 1L) -> 6</li><br><li>Tacuara (Porter) -> 1</li><br><li>Tacuara (Jim Morrison) -> 1</li><br><li>Peñon del aguila (Franbueza) -> 1</li><br><li>Peñon del aguila (Arandano) -> 1</li><br><li>Peñon del aguila (Sandia) -> 1</li><br> 
        ';
        $venta->valorVenta = 4230;
        $venta->lugar = 'Rincon de milberg->SU CASA';
        $venta->fecha = Carbon::now();
        $venta->save();

    }
}
