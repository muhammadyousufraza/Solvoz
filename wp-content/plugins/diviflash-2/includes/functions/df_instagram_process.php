<?php
class DF_Instagram_Process{
    protected $graph_url = 'https://graph.instagram.com';
    protected $client_app_id;
    protected $client_app_secret;
    protected $client_user_token;
    public $builder = false;
    public $user_token_changed = false;

    public function __construct($app_id, $app_secret,$user_token, $user_token_changed=false) {
        $this->client_app_id = $app_id;
        $this->client_app_secret = $app_secret;
        $this->client_user_token = $user_token;
        $this->user_token_changed = $user_token_changed;
    }

    // public function refresh_token($token, $app_secret , $limit=[]) {
    //     if($limit){
    //         extract($limit); // phpcs:ignore WordPress.PHP.DontExtract
    //         $limit =  !empty($item_limit)? $item_limit : $limit ;
            
    //         $transient_key ='df_instagram_refresh_token_' .$unique_module .'_'. $limit;
           
    //         $cache_type = $this->get_cacheing_time_type($cache_time_type);
        
    //         if ( '-1' == $cache_time ) {
    //             delete_transient($transient_key);
    //             $cache_time = 1;
    //             $cache_type = MINUTE_IN_SECONDS;
    //         }
            
    //         $data   = get_transient($transient_key);
    //         $url    = $this->graph_url . "/refresh_access_token?grant_type=ig_refresh_token&access_token=$token";

    //         if (false === $data || true === $this->user_token_changed ) {

    //             delete_transient($transient_key);
    //             $result = $this->remote_get($url);
    //             if ( $result->status == 200 ) {
    //                 $data       = $result->body->access_token;
    //                 set_transient($transient_key, $data, intval($cache_time) * $cache_type);
    //                 return $data;
    //             } 
    //             return $result;
    //        }

    //        return $data;
            

    //     }

    // }

    public function refresh_token($token, $app_secret) {
        $url    = $this->graph_url . "/refresh_access_token?grant_type=ig_refresh_token&access_token=$token";
        $result = $this->remote_get($url);

        if ( $result->status == 200 ) {
            return $result->body->access_token;
        }
        return $result;
    }

    public function filter_response($response) {
        if ( is_wp_error($response) ) {
            $response = array(
                'status'  => 422,
                'message' => $response->get_error_message()
            );
        } else {
            $response = array(
                'status'  => wp_remote_retrieve_response_code($response),
                'message' => wp_remote_retrieve_response_message($response),
                'body'    => json_decode(wp_remote_retrieve_body($response)),
            );
        }
        return (object)$response;
    }

    public function remote_get($url) {
        $response = wp_remote_get($url,
            array(
                'timeout'    => 100,
                'user-agent' => isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '',
            ));

        return $this->filter_response($response);
    }
    public function get_instagram_account_id($access_token , $limit=[]) {
        if($limit){
            extract($limit); // phpcs:ignore WordPress.PHP.DontExtract
            $limit =  !empty($item_limit)? $item_limit : $limit ;
            // $new_trans_key ='dfInstagramFeedData'. $access_token . $limit; 
            // $transient_key ='df_instagram_feed_data_' .$unique_module_name .'_'. $limit .'_'. $account_id;
            $transient_key ='df_instagram_account_id_' .$unique_module .'_'. $limit;
           
            $cache_type = $this->get_cacheing_time_type($cache_time_type);
        
            if ( '-1' == $cache_time ) {
                delete_transient($transient_key);
                $cache_time = 1;
                $cache_type = MINUTE_IN_SECONDS;
            }
            
            $account_id      = get_transient($transient_key);
    
            $url    = $this->graph_url . "/me?fields=id&access_token=$access_token";
    
            if (false === $account_id || true === $this->user_token_changed ) {
    
                delete_transient($transient_key);
                $result = $this->remote_get($url);
                if ( $result->status == 200 ) {
                    $account_id = $result->body->id;
                    set_transient($transient_key,  $account_id, intval($cache_time) * $cache_type);
                } else {
                    return $result;
                }
           }
           return $account_id;
        }
        

        // $result = $this->remote_get($url);
        // if ( $result->status == 200 ) {
        //     $account_id = $result->body->id;
            
        // } else {
        //     return $result;
        // }
        
        // return $account_id;
    }
    public function get_media($access_token, $account_id , $limit, $unique_module_name) {
        
        extract($limit); // phpcs:ignore WordPress.PHP.DontExtract
        $limit =  !empty($item_limit)? $item_limit : $limit ;
        // $new_trans_key ='dfInstagramFeedData'. $access_token . $limit; 
        // $transient_key ='df_instagram_feed_data_' .$unique_module_name .'_'. $limit .'_'. $account_id;
        $transient_key ='df_instagram_feed_data_' .$unique_module_name .'_'. $limit;
       
        $cache_type = $this->get_cacheing_time_type($cache_time_type);
    
        if ( '-1' == $cache_time ) {
			delete_transient($transient_key);
			$cache_time = 1;
			$cache_type = MINUTE_IN_SECONDS;
        }
        
        $data      = get_transient($transient_key);
        $url    = $this->graph_url . "/$account_id/media?fields=caption,thumbnail_url,permalink,media_type,alt,media_url,username,timestamp&access_token=$access_token&limit=$limit";
         //var_dump($data);
        if (false === $data || true === $this->user_token_changed ) {

            delete_transient($transient_key);
            $result = $this->remote_get($url);
            if ( $result->status == 200 ) {
                $data       = $result->body;
                set_transient($transient_key, $data, intval($cache_time) * $cache_type);
            } else {
                return $result;
            }
       }
       
        return $data;
    }

    protected function get_cacheing_time_type($type){
		switch ( $type ) {
			case 'minute':
				$cache_time_type = MINUTE_IN_SECONDS;
				break;
			case 'hour':
				$cache_time_type = HOUR_IN_SECONDS;
				break;
			case 'day':
				$cache_time_type = DAY_IN_SECONDS;
				break;
			case 'week':
				$cache_time_type = WEEK_IN_SECONDS;
				break;
			case 'month':
				$cache_time_type = MONTH_IN_SECONDS;
				break;
			case 'year':
				$cache_time_type = YEAR_IN_SECONDS;
				break;
			default:
				$cache_time_type = DAY_IN_SECONDS;
		}
		return $cache_time_type;
	}

    public function get_user_details($access_token, $account_id) {

       
        $url    = $this->graph_url . "/$account_id?fields=username,id,media_count,account_type&access_token=$access_token";
        $result = $this->remote_get($url);
        if ( $result->status == 200 ) {
            $data       = $result->body;
           
        } else {
            return $result;
        }
        
        return $data;
    }

    public function get_access_token($user_token, $app_secret, $limit=[]) {
        
        // $url    = $this->graph_url . "/refresh_access_token?grant_type=ig_refresh_token&&access_token=$user_token";
        // $result = $this->remote_get($url);
        // if ( $result->status == 200 ) {
        //     $accessTokenData = $result->body->access_token;
        //     $accessTokenData = $accessTokenData . '_diviflash_' . time();
            
        // } else {
        //     return $result;
        // }

        if($limit){
            extract($limit); // phpcs:ignore WordPress.PHP.DontExtract
            $limit =  !empty($item_limit)? $item_limit : $limit ;

            $transient_key ='df_instagram_access_token_' .$unique_module .'_'. $limit;
           
            $cache_type = $this->get_cacheing_time_type($cache_time_type);
        
            if ( '-1' == $cache_time ) {
                delete_transient($transient_key);
                $cache_time = 1;
                $cache_type = MINUTE_IN_SECONDS;
            }
            
            $accessTokenData   = get_transient($transient_key);
            $url    = $this->graph_url . "/refresh_access_token?grant_type=ig_refresh_token&&access_token=$user_token";
            if (false === $accessTokenData || true === $this->user_token_changed ) {

                delete_transient($transient_key);
                $result = $this->remote_get($url);
                if ( $result->status == 200 ) {
                    $accessTokenData = $result->body->access_token;
                    $accessTokenData = $accessTokenData . '_diviflash_' . time();
                    set_transient($transient_key, $accessTokenData, intval($cache_time) * $cache_type);
                } else {
                    return $result;
                }

                    // $result = $this->remote_get($url);
                    // if ( $result->status == 200 ) {
                    //     $accessTokenData = $result->body->access_token;
                    //     $accessTokenData = $accessTokenData . '_diviflash_' . time();
                        
                    // } else {
                    //     return $result;
                    // }
           }
        }
        
        $accessTokenArr = explode('_diviflash_', $accessTokenData);

        if ( count($accessTokenArr) == 2 ) {
            $access_token  = $accessTokenArr[0];
            $generatedTime = $accessTokenArr[1];
            $now           = time(); // or your date as well
            $datediff      = $now - $generatedTime;
            $totalDays     = round($datediff / (60 * 60 * 24));

            if ( $totalDays > 40 ) {
                $access_token = $this->refresh_token($access_token, $app_secret);
                
            }
            return $access_token;
        }
    }

    public function get_collect_data($app_secret, $limit , $unique_module_name) {
        $settings['instagram_user_token'] = (!empty($this->client_user_token)) ? 
            $this->client_user_token : '';

        if ( $settings['instagram_user_token'] ) {
            $instagram_user_token = $settings['instagram_user_token'];
        } elseif ( !empty($options['instagram_access_token']) ) {
            $instagram_user_token = $options['instagram_access_token'];
        } else {
            $data['error'] = 'Ops! You did not set Instagram User Token!';
            return wp_json_encode($data);
        }

        $access_token = $this->get_access_token($instagram_user_token, $app_secret , $limit);
        if ( is_string($access_token) && strlen($access_token) > 20 ) {
            $account_id = $this->get_instagram_account_id($access_token, $limit);
            if ( is_string($account_id) && strlen($account_id) > 5 ) {
                return $this->get_media(
                    $access_token, 
                    $account_id, 
                    $limit , 
                    $unique_module_name
                );
            } else {
                return $account_id;
            }
        }

        return $access_token;
    }

    public function get_instagram_data($limit, $unique_module_name) {
        $data = $this->get_collect_data($this->client_app_secret, $limit , $unique_module_name);

        if ( isset($data->data) ) {
            return $data->data;
        } else {
            if ( isset($data->status) && $data->status == 422 ) {
                echo esc_html($data->message);
            }
        }
        return [];
    }
}
    