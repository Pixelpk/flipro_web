@php
    foreach($sig[0] as $item){
        $data = str_replace($item, '<span style="color:#fff">' . $item . '</span>', $data);
    }
@endphp

{!!$data!!}