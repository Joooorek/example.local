<?php 

    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);

    if( $redis->get('script_started_bool') == 1) {

        $delay = time()-round($redis->get('script_started_time'));

        if( $delay >= 5 ) { 
            $redis->set('script_started_bool', 0);
            header("Location: /"); 
        } else { 
            sleep(5-$delay); 
            $redis->set('script_started_bool', 0);
            header("Location: /continue_after_refresh");
        }

    } elseif( $redis->get('script_started_bool') == 0) {

        $redis->set('script_started_bool', 1);
        $redis->set('script_started_time', time());

        sleep(5);
        header("Location: /continue");

    }

?>
