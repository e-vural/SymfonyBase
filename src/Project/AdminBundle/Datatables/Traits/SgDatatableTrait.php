<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2019-03-30
 * Time: 09:58
 */

namespace Project\AdminBundle\Datatables\Traits;


use Project\Utils\Custom\Twig\TwigFilters;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Symfony\Component\Routing\Router;

trait SgDatatableTrait
{



    public $editableEmptyText = "Boş";
    public $formatter = null;
    public $export_colums = array(":visible");

//    public function __construct()
//    {
//        $this->formatter = new \NumberFormatter("tr_TR", \NumberFormatter::DECIMAL);
//        $this->formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);
//    }




    private function getFormatter(){

        $this->formatter = new \NumberFormatter("tr_TR", \NumberFormatter::DECIMAL);
        $this->formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 2);

        return $this->formatter;
    }

    private function setDatatableDefaults(){


        $this->setDefaultCallbacks();

        $this->language->set(array(
            'language' => 'tr'
        ));

        $this->ajax->set(array(

        ));

        $this->options->set($this->getDatatableOptions());

        $this->features->set(array(
            'auto_width' => true,
            'defer_render' => true,
            'processing' => true,
//            'info' => false,
//            'ordering' => false
        ));

        $this->events->set(array(
//            'pre_init' => array(
//                'template' => ':datatable:init.js.twig',
//            ),
//            'error' => array(
//                'template' => ':datatable:init.js.twig',
//            ),
        ));

        $this->extensions->set($this->getDatatableExtensions());

    }


    private function getDatatableOptions(){

        return array(
//            'dom' => 'lfBtrip',
            'dom' => '<"html5buttons"B>lTfgtrip',
//            responsive
            'classes' => 'table table-striped table-bordered table-hover ',
//            'stripe_classes' => [ $router ],
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order_cells_top' => true,
            'search_in_non_visible_columns' => true,
//            'renderer' => "hello",
//            'retrieve' => true,
            'order' => array(array(0, 'desc')),
//            'defer_loading' => 1000, // geçikme vermek için kullanılır. örnek veriler 1 saniye geçikmeli görünsün gibi
            //'display_start' => 2//Hangi sayfadan başlayacağı
            'length_menu' => [[10, 25, 50, -1], [10, 25, 50, "Hepsi"]],// Kaçlı veri gösterileceğinni seçildği select
//            'order_classes' => true,
//            'order_multi' => true,
//            'defer_loading' => 500,
            'row_id' => 'id'

        );
    }

    private function getDatatableExtensions($exportColums = array(":visible")){
//        $twig  =$this->twig->render("@ProjectMain/Isletme/test.js.twig");
        return array(
            'responsive' => false,
//            'row_group' => array(
//                'start_class_name' => "test",
////                'end_class_name' => "test2",
//                'data_src' => 'isletmeTipi.baslik',
//                'start_render' => [
//                    'template' => ':datatable:row_group_start_renderer.js.twig',
//                    //'vars' => array('id' => '2', 'test' => 'new value'),
//                ],
////                'end_render' => [
////                    'template' => ':datatable:row_group_end_renderer.js.twig',
////                    //'vars' => array('id' => '2', 'test' => 'new value'),
////                ]
//            ),
            'buttons' => array(
//                'show_buttons' => array('copy', 'print'),    // built-in buttons /
                'create_buttons' => array(                   // custom buttons
//                    array(
//                        'action' => array(
//                            'template' => ':post:action.js.twig',
//                            //'vars' => array('id' => '2', 'test' => 'new value'),
//                        ),
//                        'text' => 'alert',
//                    ),
                    array(
                        'extend' => 'colvis',
                        'text' => 'Kolonlar',

                        'button_options' => array(
                            'columns'=> $exportColums,

                        ),
                    ),
                    array(
                        'extend' => 'csv',
                        'text' => 'CSV',
                    ),
                    array(
                        'extend' => 'excel',
                        'text' => 'Excel',
                        'button_options' => array(
//                            'messageTop' => "NABER", //pdf başlığının altına yazar
                            'exportOptions' => array(
                                'columns'=> $exportColums,//Sadece görünür olan fieldları çıktı alır
//                                'columns' => array('1', '2','6'),//Belirlenen filedları çıktı alır


                            ),
                        ),
                    ),
                    array(
                        'extend' => 'pdfHtml5',
                        'text' => 'PDF',
                        'name' => "name",
                        'button_options' => array(
//                            'messageTop' => "NABER", //pdf başlığının altına yazar
                            'exportOptions' => array(
                                'columns'=> $exportColums,//Sadece görünür olan fieldları çıktı alır
//                                'columns' => array('1', '2','6'),//Belirlenen filedları çıktı alır


                            ),
                        ),
                    ),
                    array(
                        'extend' => 'print',
                        'text' => 'Yazdır',
                        'button_options' => array(
                            'exportOptions' => array(
                                'columns'=> $exportColums,

                            ),

                        ),
                    ),

                ),
            ),

//            'select' => array(
//                'blurable' => false,
////                'className' => 'selected',
//                'info' => true,
//                'items' => 'row',
//                'selector' => 'td, th',
//                'style' => 'os',
//            ),
        );
    }

    private function setInitCallback(){

    }

    /**

     * @param null $route
     * @param string $routeParam
     * @see UrlGeneratorInterface
     */
    private function setRowCallback($route = null ,$routeParams = array("id" => "id"),$injectJavascript = ""){
        if(1 == 0){
            /**
             * @var Router $router
             */
            $router = $this->router;
            $router->generate($route);
        }


        $this->getCallbacks()->setRowCallback(array(
            'template' => ':datatable/callbacks:row_callback.js.twig',
            'vars' => array("route" => $route,"routeParams" => $routeParams,"injectJavascript" => $injectJavascript),
        ));
    }

    private function setDrawCallback(){

    }

    private function setDefaultCallbacks(){

//        $this->router->generate($route,array("$routeParams" => $id));

        $this->callbacks->set(array(
            'init_complete' => array(
                'template' => ':datatable/callbacks:init_callback.js.twig',
                'vars' => array('tr_click_route' => "project_main_isletme_detay"),

            ),
            'draw_callback' => array(
                'template' => ':datatable/callbacks:draw_callback.js.twig',
                'vars' => array('table_name' => $this->getName()),

            ),
//            'pre_draw_callback' => array(
//                'template' => ':datatable:pre_draw.js.twig',
//            ),
        ));
//        return array(
//            'init_complete' => array(
//                'template' => ':datatable/callbacks:init_callback.js.twig',
//                'vars' => array('tr_click_route' => "project_main_isletme_detay"),
//
//            ),
//            'draw_callback' => array(
//                'template' => ':datatable/callbacks:draw_callback.js.twig',
//            ),
////            'pre_draw_callback' => array(
////                'template' => ':datatable:pre_draw.js.twig',
////            ),
//        );
    }

    private function numberColumn($yourParams = array(),$add_string_end = "")
    {

        $defaults =  array(
            'start_html' => "<span class='display-grid label label-default'>",
            'end_html' => " $add_string_end</span>",
            'formatter' =>  $this->getFormatter(),
            'default_content' => "0,00"
        );

        return array_merge($defaults,$yourParams);

    }

    private function columtnToNumberColumn($yourParams = array())
    {

        $defaults =  array(
            'filter' => array(NumberFilter::class, array(
                'search_type' => 'gte',
                'type' => 'number',
        )));

        return array_merge($defaults,$yourParams);

    }

    private function paraBirimi($value,$paraBirimiIkon,$spanType ="default",$formatter = true){
        $twigFilters = $this->conatiner->get(TwigFilters::class);
        if($formatter){
            $value = $this->getFormatter()->format($value);
        }

        $response = $value." ".$paraBirimiIkon;
        if($spanType){
            $response = $twigFilters->spanLabel($response,$spanType,"display-grid")->jsonSerialize();
        }
        return $response;
    }
}
