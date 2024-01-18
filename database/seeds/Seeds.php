<?php
use Illuminate\Database\Seeder;

class Seeds extends Seeder
{
    public function run()
    {
        //BRANCHES
        DB::unprepared('SET IDENTITY_INSERT branches ON');
        DB::table('branches')->insert([
            'id'            => 1,
            'branch'        => 'Sucursal Central',
            'phone_number'  => 503,
        ]);
        DB::unprepared('SET IDENTITY_INSERT branches OFF');

        //AREAS
        DB::unprepared('SET IDENTITY_INSERT areas ON');
        DB::table('areas')->insert([
            'id'        => 1,
            'area'   => 'Recepción y entrega en caja',
        ]);
        DB::table('areas')->insert([
            'id'        => 2,
            'area'   => 'Recepción y entrega a domicilio',
        ]);
        DB::table('areas')->insert([
            'id'        => 3,
            'area'   => 'Fabricación y ensamblaje',
        ]);
        DB::table('areas')->insert([
            'id'        => 4,
            'area'   => 'Empaquetado y almacenaje',
        ]);
        DB::table('areas')->insert([
            'id'        => 5,
            'area'   => 'Evaluación, enviñetado y despacho',
        ]);
        DB::table('areas')->insert([
            'id'        => 6,
            'area'   => 'Administración',
        ]);
        DB::table('areas')->insert([
            'id'        => 7,
            'area'   => 'Publico en general',
        ]);
        DB::unprepared('SET IDENTITY_INSERT areas OFF');

        //USERS
        DB::unprepared('SET IDENTITY_INSERT users ON');
        DB::table('users')->insert([
            'id'                => 1,
            'branch_id'         => 1,
            'area_id'           => 6,
            'name'              => 'system',
            'email'             => 'system@gmail.com',
            'password'          => bcrypt('R3@lb1nd3r'),
            'remember_token'    => Str::random(10),
            'autoservicio'      => 0,
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'id'                => 2,
            'branch_id'         => 1,
            'area_id'           => 1,
            'name'              => 'Criss Angel',
            'email'             => 'cangel@gmail.com',
            'password'          => bcrypt('123456'),
            'remember_token'    => Str::random(10),
            'autoservicio'      => 0,
            'email_verified_at' => now(),
        ]);
        DB::unprepared('SET IDENTITY_INSERT users OFF');

        //OPTIONS
        DB::unprepared('SET IDENTITY_INSERT options ON');
        DB::table('options')->insert([
            'id'=> '1',
            'option'=> 'Tax rate',
            'value'=> '13',
        ]);
        DB::table('options')->insert([
            'id'=> '2',
            'option'=> 'Tax included into charge',
            'value'=> '1',
        ]);
        DB::table('options')->insert([
            'id'=> '3',
            'option'=> 'Discount rate',
            'value'=> '0',
        ]);
        DB::unprepared('SET IDENTITY_INSERT options OFF');

        //ROLES
        DB::unprepared('SET IDENTITY_INSERT roles ON');
        DB::table('roles')->insert([
            'id'                => 1,
            'role'              => 'Vendedor',
            'icon'              => '<div class="livicon-evo" data-options=" name: gift.svg; style: solid; size: 37px; solidColor: #61adfe; colorsOnHover: lighter "></div>'
        ]);
        DB::table('roles')->insert([
            'id'                => 2,
            'role'              => 'Cajero',
            'icon'              => '<div class="livicon-evo" data-options=" name: calculator.svg; style: solid; size: 37px; solidColor: #61adfe; colorsOnHover: lighter "></div>'
        ]);
        DB::table('roles')->insert([
            'id'                => 3,
            'role'              => 'Diseñador',
            'icon'              => '<div class="livicon-evo" data-options=" name: image.svg; style: solid; size: 37px; solidColor: #61adfe; colorsOnHover: lighter "></div>'
        ]);
        DB::table('roles')->insert([
            'id'                => 4,
            'role'              => 'Ensamblador',
            'icon'              => '<div class="livicon-evo" data-options=" name: gear.svg; style: solid; size: 37px; solidColor: #61adfe; colorsOnHover: lighter "></div>'
        ]);
        DB::table('roles')->insert([
            'id'                => 5,
            'role'              => 'Gestor de calidad',
            'icon'              => '<div class="livicon-evo" data-options=" name: check.svg; style: solid; size: 37px; solidColor: #61adfe; colorsOnHover: lighter "></div>'
        ]);
        DB::table('roles')->insert([
            'id'                => 6,
            'role'              => 'Bodeguero',
            'icon'              => '<div class="livicon-evo" data-options=" name: building.svg; style: solid; size: 37px; solidColor: #61adfe; colorsOnHover: lighter "></div>'
        ]);
        DB::table('roles')->insert([
            'id'                => 7,
            'role'              => 'Motorista',
            'icon'              => '<div class="livicon-evo" data-options=" name: truck.svg; style: solid; size: 37px; solidColor: #61adfe; colorsOnHover: lighter "></div>'
        ]);
        DB::table('roles')->insert([
            'id'                => 8,
            'role'              => 'Administrador',
            'icon'              => '<div class="livicon-evo" data-options=" name: line-chart.svg; style: solid; size: 37px; solidColor: #ffc13a; colorsOnHover: lighter "></div>'
        ]);
        DB::table('roles')->insert([
            'id'                => 9,
            'role'              => 'Supervisor',
            'icon'              => '<div class="livicon-evo" data-options=" name: like.svg; style: solid; size: 37px; solidColor: #61adfe; colorsOnHover: lighter "></div>'
        ]);
        DB::unprepared('SET IDENTITY_INSERT roles OFF');

        //SERVICE TYPES
        DB::unprepared('SET IDENTITY_INSERT service_types ON');
        DB::table('service_types')->insert([
            'id'    => 1,
            'type'  => 'Autorización',
            'icon'  => 'bx bxs-lock font-large-1',
        ]);
        DB::table('service_types')->insert([
            'id'    => 2,
            'type'  => 'Atención al cliente',
            'icon'  => 'bx  bxs-cog font-large-1',
        ]);
        DB::table('service_types')->insert([
            'id'    => 3,
            'type'  => 'Mano de obra',
            'icon'  => 'bx bxs-user font-large-1',
        ]);
        DB::table('service_types')->insert([
            'id'    => 4,
            'type'  => 'Producto',
            'icon'  => 'bx bxs-purchase-tag-alt font-large-1',
        ]);
        DB::unprepared('SET IDENTITY_INSERT service_types OFF');

        //PAYMENT_TYPES
        DB::unprepared('SET IDENTITY_INSERT payment_types ON');
        DB::table('payment_types')->insert([
            'id'            => 1,
            'type'          => 'Efectivo',
            'cashbox_in'    => 1,
        ]);
        DB::table('payment_types')->insert([
            'id'            => 2,
            'type'          => 'Post',
            'cashbox_in'    => 0,
        ]);
        DB::table('payment_types')->insert([
            'id'            => 3,
            'type'          => 'Bitcoin',
            'cashbox_in'    => 0,
        ]);
        DB::table('payment_types')->insert([
            'id'            => 4,
            'type'          => 'Cheque',
            'cashbox_in'    => 0,
        ]);
        DB::table('payment_types')->insert([
            'id'            => 5,
            'type'          => 'Pagaré',
            'cashbox_in'    => 0,
        ]);
        DB::table('payment_types')->insert([
            'id'            => 6,
            'type'          => 'Quedan',
            'cashbox_in'    => 0,
        ]);
        DB::unprepared('SET IDENTITY_INSERT payment_types OFF');

        //SERVICIOS DE AUTORIZACIÓN
        DB::unprepared('SET IDENTITY_INSERT services ON');
        DB::table('services')->insert([ //DISPONIBLE
            'id'                    => 50,
            'service'               => 'Reporte de ventas',
            'route'                 => 'automation.reporte-ventas',
            'service_type_id'       => 1,
            'cost'                  => 1.999999,
            'charge'                => 2.999999,
            'private_net'           => 1,
        ]);
        DB::table('services')->insert([
            'id'                             => 1,
            'service_type_id'   => 1,
            'service'                   => 'Catálogo de ofertas',
            'route'                      => 'cart.offers',
            'cost'                        => 1.999999,
            'charge'                    => 2.999999,
            'private_net'           => 0,
        ]);
        DB::table('services')->insert([
            'id'                             => 81,
            'service_type_id'   => 1,
            'service'                   => 'Catálogo de productos',
            'route'                      => 'cart.products',
            'cost'                        => 1.999999,
            'charge'                    => 2.999999,
            'private_net'           => 0,
        ]);
        DB::table('services')->insert([
            'id'                => 2,
            'service_type_id'   => 1,
            'service'           => 'Operadores',
            'icon'          => '<i class="bx bxs-user-rectangle font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'user',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'                => 3,
            'service_type_id'   => 1,
            'service'           => 'Disponible dos',
            'icon'          => '<i class="bx bxs-user-check font-large-1" style="color: #ffc13a"></i>',
            'route'             => '#',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 4,
            'service'           => 'Clientes',
            'service_type_id'   => 1,
            'icon'          =>  '<i class="bx bxs-face font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'user',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'                => 5,
            'service_type_id'   => 1,
            'service'           => 'Formulario registro de usuario',
            'route'             => 'user.create',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'private_net'       => 0,
        ]);
        DB::table('services')->insert([
            'id'                => 66,
            'service_type_id'   => 1,
            'service'           => 'Crear usuario',
            'route'             => 'user.store',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'private_net'       => 0,
        ]);
        DB::table('services')->insert([
            'id'                => 6,
            'service_type_id'   => 1,
            'service'           => 'Formulario de edición para el usuario',
            'route'             => 'user.edit',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 78,
            'service_type_id'   => 1,
            'service'           => 'Actualizar usuario',
            'route'             => 'user.update',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 7,
            'service_type_id'   => 1,
            'service'           => 'Dar de baja a un usuario',
            'route'             => 'user.undo',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 80,
            'service_type_id'   => 1,
            'service'           => 'Formulario asignación de roles al usuario',
            'route'             => 'user.bind',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 8,
            'service_type_id'   => 1,
            'service'           => 'Asignar roles al usuario',
            'route'             => 'user.set',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 9,
            'service_type_id'   => 1,
            'service'           => 'Asignar el puesto de operador al aplicante',
            'route'             => 'user.hired',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([ //Roles
            'id'                => 10,
            'service_type_id'   => 1,
            'service'           => 'Roles',
            'icon'          => '<i class="bx bx-street-view font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'role',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'                => 11,
            'service_type_id'   => 1,
            'service'           => 'Formulario de registro para el rol',
            'route'             => 'role.create',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 67,
            'service_type_id'   => 1,
            'service'           => 'Crear el rol',
            'route'             => 'role.store',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 12,
            'service_type_id'   => 1,
            'service'           => 'Formulario de edición para el role',
            'route'             => 'role.edit',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 68,
            'service_type_id'   => 1,
            'service'           => 'Actualizar el rol',
            'route'             => 'role.update',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 13,
            'service_type_id'   => 1,
            'service'           => 'Formulario asignación de servicios para el rol',
            'route'             => 'role.bind',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 79,
            'service_type_id'   => 1,
            'service'           => 'Asignar servicios al rol',
            'route'             => 'role.set',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 14,
            'service_type_id'   => 1,
            'service'           => 'Dar de baja a un rol',
            'route'             => 'role.undo',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 15,
            'service_type_id'   => 1,
            'service'           => 'Ofertas',
            'icon'          => '<i class="bx bxs-gift font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'offer',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'                => 16,
            'service_type_id'   => 1,
            'service'           => 'Formulario de registro para la oferta',
            'route'             => 'offer.create',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 74,
            'service_type_id'   => 1,
            'service'           => 'Crear oferta',
            'route'             => 'offer.store',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 17,
            'service_type_id'   => 1,
            'service'           => 'Formulario de edición para la oferta',
            'route'             => 'offer.edit',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 69,
            'service_type_id'   => 1,
            'service'           => 'Actualizar la oferta',
            'route'             => 'offer.update',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 18,
            'service_type_id'   => 1,
            'service'           => 'Formulario asignar servicios a la oferta',
            'route'             => 'offer.bind',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 19,
            'service_type_id'   => 1,
            'service'           => 'Dar de baja a una oferta',
            'route'             => 'offer.undo',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 20,
            'service_type_id'   => 1,
            'service'           => 'Sucursales',
            'icon'          =>      '<i class="bx bxs-store font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'branch',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'                => 21,
            'service_type_id'   => 1,
            'service'           => 'Formulario de registro para la sucursal',
            'route'             => 'branch.create',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 71,
            'service_type_id'   => 1,
            'service'           => 'Crear una sucursal',
            'route'             => 'branch.store',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 22,
            'service_type_id'   => 1,
            'service'           => 'Formulario de edición para la sucursal',
            'route'             => 'branch.edit',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 75,
            'service_type_id'   => 1,
            'service'           => 'Actualizar sucursal',
            'route'             => 'branch.update',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 23,
            'service_type_id'   => 1,
            'service'           => 'Dar de baja una sucursal',
            'route'             => 'branch.undo',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 24,
            'service_type_id'   => 1,
            'service'           => 'Productos',
            'icon'          =>  '<i class="bx bxs-shopping-bag font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'service',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'                => 25,
            'service_type_id'   => 1,
            'service'           => 'Formulario de registro para un producto/servicio',
            'route'             => 'service.create',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 72,
            'service_type_id'   => 1,
            'service'           => 'Crear un producto/servicio',
            'route'             => 'service.store',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 26,
            'service_type_id'   => 1,
            'service'           => 'Formulario de edición para un producto/servicio',
            'route'             => 'service.edit',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 73,
            'service_type_id'   => 1,
            'service'           => 'Actualización de un producto/servicio',
            'route'             => 'service.update',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 27,
            'service_type_id'   => 1,
            'service'           => 'Dar de baja a producto/servicio',
            'route'             => 'service.undo',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 28,
            'service_type_id'   => 1,
            'service'           => 'Mis actividades',
            'route'             => 'task',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([ 
            'id'                => 29,
            'service_type_id'   => 1,
            'service'           => 'Dar de baja una actividad',
            'route'             => 'task.undo',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 30,
            'service_type_id'   => 1,
            'service'           => 'Delegar un re-proceso',
            'route'             => 'task.redo',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 31,
            'service_type_id'   => 1,
            'service'           => 'Revisar una actividad',
            'route'             => 'task.inspect',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 32,
            'service'           => 'Agregar un producto al carrito',
            'route'             => 'cart.product-store',
            'service_type_id'   => 1,
            'cost'              => 1.99,
            'charge'            => 2.99,
        ]);
        DB::table('services')->insert([
            'id'                => 33,
            'service'           => 'Cambio de catálogo',
            'route'             => 'cart.catalog-switch',
            'service_type_id'   => 1,
            'cost'              => 1.99,
            'charge'            => 2.99,
        ]);
        DB::table('services')->insert([
            'id'                => 34,
            'service_type_id'   => 1,
            'service'           => 'Gestión',
            'icon'          =>  '<i class="bx bxs-traffic font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'task.manager',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'                => 35,
            'service_type_id'   => 1,
            'service'           => 'Reportar actividad',
            'route'             => 'task.do',
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 82,
            'service_type_id' => 1,
            'service'   => 'Abastecimiento',
            'route'             => 'cart.stock-supplying',
            'icon'      =>  '<i class="bx bxl-stack-overflow font-large-1" style="color: #ffc13a"></i>',
            'cost'      => 1.999999,
            'charge'    => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'        => 63,
            'service_type_id' => 1,
            'service'   => 'Abastecer el stock',
            'route'             => 'cart.stock-supply',
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 37,
            'service_type_id' => 1,
            'service'   => 'Factura',
            'route'             => 'sale',
            'icon'      =>  '<i class="bx bx-dollar font-large-1" style="color: #ffc13a"></i>',
            'cost'      => 1.999999,
            'charge'    => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'                => 38,
            'service'           => 'Enviar correos',
            'route'             => 'automation.send-mail',
            'service_type_id'   => 1,
            'cost'              => 1.99,
            'charge'            => 2.99,
        ]);
        DB::table('services')->insert([
            'id'        => 39,
            'service_type_id' => 1,
            'service'   => 'Ver carretilla',
            'route'     => 'cart.check',
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 62,
            'service'           => 'Agregar una oferta al carrito',
            'route'             => 'cart.offer-store',
            'service_type_id'   => 1,
            'cost'              => 1.99,
            'charge'            => 2.99,
        ]);
        DB::table('services')->insert([
            'id'                => 51,
            'service'           => 'Tipos de pago',
            'icon'          =>  '<i class="bx bxs-credit-card font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'payment-type',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1,
        ]);
        DB::table('services')->insert([
            'id'                => 52,
            'service'           => 'Formulario de registro para tipos de pago',
            'route'             => 'payment-type.create',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 76,
            'service'           => 'Crear tipo de pago',
            'route'             => 'payment-type.store',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 53,
            'service'           => 'Formulario de edición para tipo de pago',
            'route'             => 'payment-type.edit',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 77,
            'service'           => 'Actualizar tipo de pago',
            'route'             => 'payment-type.update',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);        DB::table('services')->insert([
            'id'                => 54,
            'service'           => 'Dar de baja a tipos de pago',
            'route'             => 'payment-type.undo',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 55,
            'service'           => 'Cerrar-caja',
            'route'             => 'cashbox.close',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 56,
            'service'           => 'Detalle de caja',
            'route'             => 'cashbox.detail',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 57,
            'service'           => 'Histórico de Cajas',
            'icon'          =>  '<i class="bx bxs-calendar-event font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'cashbox.history',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1
        ]);
        DB::table('services')->insert([
            'id'                => 58,
            'service'           => 'Mi cuadre de caja',
            'route'             => 'cashbox.square',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 59,
            'service'           => 'Configuratión',
            'route'             => 'automation.option',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 60,
            'service'           => 'Mostrar factura registrada',
            'route'             => 'sale',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 61,
            'service'           => 'Re-imprimir factura',
            'route'             => 'cashbox.pdf-reprint',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 65,
            'service_type_id' => 1,
            'service'   => 'Descargar factura digital',
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 83,
            'service'           => 'Efectuar compra',
            'route'             => 'cart.purchase',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'                => 84,
            'service'           => 'Ver mis tareas',
            'route'             => 'task',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 41,
            'service'   => 'Ver la orden pendiente',
            'route'             => 'sale',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
            'private_net' => 0,
        ]);
        DB::table('services')->insert([
            'id'                => 70,
            'service'           => 'Reportes',
            'icon'              =>  '<i class="bx bxs-bar-chart-square font-large-1" style="color: #ffc13a"></i>',
            'route'             => 'automation.private-reports',
            'service_type_id'   => 1,
            'cost'              => 1.999999,
            'charge'            => 2.999999,
            'menu'              => 1,
            'private_net'       => 0,
        ]);
        DB::table('services')->insert([
            'id'        => 36,
            'service'   => 'Enviar correo oferta',
            'route'             => 'automation.offer-send',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 85,
            'service'   => 'Generar pdf de la factura',
            'route'             => 'sale.pdf-invoice',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 86,
            'service'   => 'Facturar',
            'route'             => 'sale.save-invoice',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 87,
            'service'   => 'Asignar servicios a la oferta',
            'route'             => 'offer.set',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 89,
            'service'   => 'Retirar oferta solicitada',
            'route'             => 'cart.offer-undo',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 90,
            'service'   => 'Revisar los item de la oferta',
            'route'             => 'cart.offer-check',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 91,
            'service'   => 'Modificar la orden solicitada',
            'route'             => 'cart.offer-update',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 92,
            'service'   => 'Modificar items de la orden solicitada',
            'route'             => 'cart.product-update',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 93,
            'service'   => 'Retirar item de la oferta/producto',
            'route'             => 'cart.product-undo',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 94,
            'service'   => 'Buscar y mostrar orden según número',
            'route'             => 'sale.search',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 95,
            'service'   => 'Buscar y mostrar usuario',
            'route'             => 'user.search',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 96,
            'service'   => 'Buscar y mostrar producto/servicio en galeria',
            'route'             => 'cart.product-search',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 97,
            'service'   => 'Buscar y mostrar producto/servicio en zona de abastecimiento',
            'route'             => 'cart.supplying-search',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 98,
            'service'   => 'Consultar factura',
            'route'             => 'cashbox.data-invoice',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 99,
            'service'   => 'Revisar las actividades del operador',
            'route'             => 'task',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 100,
            'service'   => 'Anular factura',
            'route'             => 'cashbox.nullify-invoice',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 101,
            'service'   => 'Buscar y mostrar producto/servicio en catálogo',
            'route'             => 'service.search',
            'service_type_id' => 1,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 64,
            'service_type_id' => 1,
            'service'   => 'Enviar factura digital',
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);

        //SERVICIOS DE ATENCIÓN AL CLIENTE
        DB::table('services')->insert([
            'id'        => 88,
            'service'   => 'Vendido',
            'service_type_id' => 2,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);
        DB::table('services')->insert([
            'id'        => 102,
            'service'   => 'Facturado',
            'service_type_id' => 2,
            'cost'      => 1.999999,
            'charge'    => 2.999999,
        ]);

        DB::unprepared('SET IDENTITY_INSERT services OFF');

        //ROLE_SERVICE
        DB::table('role_service')->insert([ //VENDEDOR
            'role_id'              => 1,
            'service_id'           => 1,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 36,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 95,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 4,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 5,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 66,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 28,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 32,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 33,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 38,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 39,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 35,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 81,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 84,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 89,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 90,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 91,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 92,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 93,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 83,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 96,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 62,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 1,
            'service_id'           => 88,
        ]);

        DB::table('role_service')->insert([ //CAJERO
            'role_id'              => 2,
            'service_id'           => 37,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 60,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 58,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 41,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 28,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 35,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 1,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 33,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 55,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 56,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 64,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 84,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 41,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 86,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 94,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 85,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 98,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 81,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 96,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 2,
            'service_id'           => 102,
        ]);

        DB::table('role_service')->insert([ //DISEÑADOR
            'role_id'              => 3,
            'service_id'           => 1,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 3,
            'service_id'           => 33,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 3,
            'service_id'           => 28,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 3,
            'service_id'           => 35,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 3,
            'service_id'           => 84,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 3,
            'service_id'           => 81,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 3,
            'service_id'           => 96,
        ]);

        DB::table('role_service')->insert([ //FABRICANTE
            'role_id'              => 4,
            'service_id'           => 1,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 4,
            'service_id'           => 33,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 4,
            'service_id'           => 28,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 4,
            'service_id'           => 35,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 4,
            'service_id'           => 84,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 4,
            'service_id'           => 81,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 4,
            'service_id'           => 96,
        ]);
        DB::table('role_service')->insert([ //GESTOR DE CALIDAD
            'role_id'              => 5,
            'service_id'           => 29,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 30,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 31,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 1,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 2,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 33,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 28,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 31,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 35,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 56,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 57,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 60,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 61,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 84,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 99,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 81,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 96,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 99,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 98,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 95,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 5,
            'service_id'           => 65,
        ]);

        DB::table('role_service')->insert([ //BODEGUERO
            'role_id'              => 6,
            'service_id'           => 1,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 6,
            'service_id'           => 33,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 6,
            'service_id'           => 28,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 6,
            'service_id'           => 35,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 6,
            'service_id'           => 63,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 6,
            'service_id'           => 82,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 6,
            'service_id'           => 84,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 6,
            'service_id'           => 97,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 6,
            'service_id'           => 81,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 6,
            'service_id'           => 96,
        ]);

        DB::table('role_service')->insert([ //MOTORISTA
            'role_id'              => 7,
            'service_id'           => 28,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 7,
            'service_id'           => 1,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 7,
            'service_id'           => 33,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 7,
            'service_id'           => 35,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 7,
            'service_id'           => 84,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 7,
            'service_id'           => 81,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 7,
            'service_id'           => 96,
        ]);

        DB::table('role_service')->insert([ //ADMINISTRADOR
            'role_id'              => 8,
            'service_id'        => 1,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'        => 2,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'        => 4,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'        => 5,
        ]);
        DB::table('role_service')->insert([
            'role_id'            => 8,
            'service_id'      => 6,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 7,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 8,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 9,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 10,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 11,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 12,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 13,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 14,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 15,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 16,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 17,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 18,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 19,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 20,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 21,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 22,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 23,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 24,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 25,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 26,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 27,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 28,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 29,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 30,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 31,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 32,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 33,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 34,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 35,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 36,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 37,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 38,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 39,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 41,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 38,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 51,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 52,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 53,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 54,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 55,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 56,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 57,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 58,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 59,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 60,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 61,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 62,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 63,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 64,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 65,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 66,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 67,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 68,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'         => 69,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'         => 70,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'         => 71,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 72,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 73,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 74,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 75,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 76,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 77,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 78,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 79,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 80,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 81,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 82,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 83,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 84,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 85,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 86,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 87,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 89,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 90,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 91,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 92,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 93,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 93,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 95,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 96,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 97,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 98,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 99,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 100,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 8,
            'service_id'           => 101,
        ]);

        DB::table('role_service')->insert([ //SUPERVISOR
            'role_id'              => 9,
            'service_id'           => 1,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 9,
            'service_id'           => 2,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 9,
            'service_id'           => 33,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 9,
            'service_id'           => 34,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 9,
            'service_id'           => 84,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 9,
            'service_id'           => 100,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 9,
            'service_id'           => 81,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 9,
            'service_id'           => 96,
        ]);
        DB::table('role_service')->insert([
            'role_id'              => 9,
            'service_id'           => 35,
        ]);


        //ROLE_USER
        DB::table('role_user')->insert([
            'user_id'           => 1,
            'role_id'           => 8,
        ]);
        
        DB::table('role_user')->insert([
            'user_id'           => 2,
            'role_id'           => 1,
        ]);
                
        //OFFERS
        DB::unprepared('SET IDENTITY_INSERT offers ON');
        DB::table('offers')->insert([ //Oferta puente
            'id'                    => 1,
            'offer'                 => 'Producto individual',
            'charge'                => 0,
        ]);
        DB::unprepared('SET IDENTITY_INSERT role_user OFF');

        DB::table('offer_service')->insert([
            'service_id'    => 1,
            'offer_id'      => 1,
        ]);
    }
}