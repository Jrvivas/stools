<?php

namespace app\views\controls;
class Img {
   static public function  icon($nombre,$class="",$width='32px',$height='32px'){
        return '<img src="assets/icons/'.$nombre.'.svg" alt="'.$nombre.'" style="width:'.$width.'; height:'.$height.'" />';
    }


    static public function  icon_dinero($color='currentColor'){
        return '<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-cash-stack" fill='.$color.' xmlns="http://www.w3.org/2000/svg">
                <path d="M14 3H1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1h-1z"/>
                <path fill-rule="evenodd" d="M15 5H1v8h14V5zM1 4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H1z"/>
                <path d="M13 5a2 2 0 0 0 2 2V5h-2zM3 5a2 2 0 0 1-2 2V5h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 13a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                </svg>';
    }
    static public function  icon_user($color='currentColor'){
        return '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="'.$color.'" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>';
    }

    static public function icon_fecha($color='currentColor'){
        return '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar-plus" fill="'.$color.'" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                </svg>';
    }
                 

 }
?>