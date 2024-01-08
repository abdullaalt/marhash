<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientController;
use Closure;

class Centrifuge
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		$headers = getallheaders();
		$app_id = isset($headers['User-Token']) || isset($headers['user-token']);
		$request->session()->put('channel1', 'dd');
        if (Auth::check()) {
			$user = Auth::user();
            //$token = $app_id ? $postdata['firebase_token'] : $request->firebase_token;

					$client = new ClientController("https://gargalo.ru:8082/api");
					$client->setApiKey('cr43cr43crc4r43cr4k3ct9rr4c');
					
					/*if ($token) {
						DB::table('push_tokens')->where('token', $token)->delete();
						DB::table('push_tokens')->insert(array('user_id'=>$user->id, 'token'=>$token));
					}*/
                    
                    if ($app_id){
					
						$centrifuge_info = DB::table('centrifuge')->where('source', 'app')->where('user_id', $user->id)->first();
						if ($centrifuge_info){
							$cent_token  =  $centrifuge_info->token;

							$channel = $centrifuge_info->channel;
							$request->session()->put('channel', $channel);
						}else{
							$cent_token  =  $client->setSecret('x434x3434r43t5vt5vt5vx32rh')->generateConnectionToken($user->id);

							$channel = $client->getChanel($user->id*(-55));
							
							DB::table('centrifuge')->insert(array('user_id'=>$user->id, 'token'=>$cent_token, 'channel'=>$channel, 'source'=>'app'));
						}
						
						$result = json_decode(json_encode($user), true);
						$result['cent_token'] = $cent_token;
						$result['channel'] = $channel;
    					die(json_encode($result));
    				}
					
					$centrifuge_info = DB::table('centrifuge')->where('source', 'site')->where('user_id', $user->id)->first();
					if ($centrifuge_info){
						$cent_token  =  $centrifuge_info->token;

						$channel = $centrifuge_info->channel;
						$request->session()->put('channel', $channel);
						$request->session()->put('token', $cent_token);
					}else{
						$cent_token  =  $client->setSecret('x434x3434r43t5vt5vt5vx32rh')->generateConnectionToken($user->id);

						$channel = $client->getChanel($user->id*(-55));
						$request->session()->put('channel', $channel);
						$request->session()->put('token', $cent_token);
							
						DB::table('centrifuge')->insert(array('user_id'=>$user->id, 'token'=>$cent_token, 'channel'=>$channel, 'source'=>'site'));
					}
        }
        return $next($request);
    }
}
