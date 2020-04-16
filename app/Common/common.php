<?php

function jsonReturn($status=1, $msg='', $data=null, $extra=null){
    $config = config('ajaxMsg');
    $tips = $config['tips'];

    $temp = $config['content'];
    $status = $temp[$status]['status'];
    $msg = $msg ?: $temp[$status]['msg'];
    $data = $data ?: $temp[$status]['data'];
    return response()->json([$tips['status']=>$status, $tips['msg']=>$msg, $tips['data']=>$data, $tips['extra']=>$extra]);
}
