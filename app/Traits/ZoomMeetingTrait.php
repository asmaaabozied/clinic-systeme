<?php
namespace App\Traits;

use GuzzleHttp\Client;
use App\Models\Utility;
use Illuminate\Support\Facades\Log;

/**
 * trait ZoomMeetingTrait
 */
trait ZoomMeetingTrait
{
    public $client;
    public $jwt;
    public $headers;
    public $meeting_url="https://api.zoom.us/v2/";

    // Meeting type constants
    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;

    private function ensureClient()
    {
        if (!$this->client) {
            $this->client = new \GuzzleHttp\Client();
        }
    }

    private function retrieveZoomUrl()
    {
        return $this->meeting_url;
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : '.$e->getMessage());

            return '';
        }
    }

    public function createMeeting($data)
    {
        $this->ensureClient();
        $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->getHeader(),
            'body'    => json_encode([
                'topic'      => $data['title'],
                'type'       => $data['type'] ?? self::MEETING_TYPE_SCHEDULE,
                'start_time' => isset($data['start_time']) ? $this->toZoomTimeFormat($data['start_time']) : null,
                'duration'   => $data['duration'],
                'password' => $data['password'] ?? null,
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Kolkata',
                'settings'   => [
                    'host_video'        => ($data['host_video'] ?? "1") == "1" ? true : false,
                    'participant_video' => ($data['participant_video'] ?? "1") == "1" ? true : false,
                    'waiting_room'      => true,
                    'auto_recording'    => $data['auto_recording'] ?? 'cloud',
                    'alternative_hosts' => $data['alternative_hosts'] ?? null,
                ],
            ]),
        ];

        $response =  $this->client->post($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];

    }

    public function createInstantMeeting($data)
    {
        $this->ensureClient();
        $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->getHeader(),
            'body'    => json_encode([
                'topic'      => $data['title'],
                'type'       => self::MEETING_TYPE_INSTANT,
                'duration'   => $data['duration'] ?? 60,
                'password'   => $data['password'] ?? null,
                'agenda'     => $data['agenda'] ?? null,
                'settings'   => [
                    'host_video'        => true,
                    'participant_video' => true,
                    'waiting_room'      => true,
                    'auto_recording'    => 'cloud',
                    'join_before_host'  => false,
                    'mute_upon_entry'   => false,
                ],
            ]),
        ];

        $response = $this->client->post($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function getMeetingRecordings($meetingId)
    {
        $this->ensureClient();
        $path = 'meetings/' . $meetingId . '/recordings';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->getHeader(),
        ];

        $response = $this->client->get($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 200,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function meetingUpdate($id, $data)
    {
        $this->ensureClient();
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->getHeader(),
            'body'    => json_encode([
                'topic'      => $data['title'],
                'type'       => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration'   => $data['duration'],
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => config('app.timezone'),
                'settings'   => [
                    'host_video'        => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
        ];


        $response =  $this->client->patch($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function get($id)
    {
        $this->ensureClient();
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->getHeader(),
            'body'    => json_encode([]),
        ];

            $response =  $this->client->get($url.$path, $body);
            return [
                'success' => $response->getStatusCode() === 204,
                'data'    => json_decode($response->getBody(), true),
            ];


    }

    /**
     * @param string $id
     *
     * @return bool[]
     */
    public function delete($id)
    {
        $this->ensureClient();
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->delete($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
        ];
    }

    public function getHeader()
    {
        $this->ensureClient();
        return [
            'Authorization' => 'Bearer '.$this->getToken(),
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    public function getToken()
    {
        $this->ensureClient();
        // Check if Zoom credentials are configured
        $settings = Utility::settings(\Auth::user()->id);
        if (
            isset($settings['zoom_account_id']) && !empty($settings['zoom_account_id']) &&
            isset($settings['zoom_client_id']) && !empty($settings['zoom_client_id']) &&
            isset($settings['zoom_client_secret']) && !empty($settings['zoom_client_secret'])
        ) {
            // Construct the basic authentication header
            $basicAuthHeader = base64_encode($settings['zoom_client_id'] . ':' . $settings['zoom_client_secret']);

            // Prepare the request to obtain the access token
            $response = $this->client->request('POST', 'https://zoom.us/oauth/token', [
                'headers' => [
                    'Authorization' => 'Basic ' . $basicAuthHeader,
                ],
                'form_params' => [
                    'grant_type' => 'account_credentials',
                    "account_id" =>  $settings['zoom_account_id']
                ],
            ]);


            // Decode the response and retrieve the access token
            $token = json_decode($response->getBody(), true);

            if (isset($token['access_token'])) {
                return $token['access_token'];
            }
        }

        return false;
    }


}





