<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Requests\DataStatusRequest;
use App\Models\ServerStat;
use Illuminate\Http\JsonResponse;

class DataStatusController
{
    const DEFAULT_CHECK_PERIOD = 10;

    /**
     * Data Status
     *
     * You can check the latest state of your stored data. For more details check the output.
     * @group         Pull Information
     * @queryParam    period integer Check the data in the given period in minutes (min: 5). Default: 10 Example: 10
     * @responseField new_data_in_period integer Count of new data in the given period
     * @responseField latest_data_sent_at string Timestamp of the latest data.
     * @responseField latest_data_diff_minutes integer Diff in minutes of the latest data.
     * @responseField possible_problem_detected boolean To check the response quickly, this flag indicates if a
     * possible problem was found.
     * @responseField server_time string Current server time
     * @response      scenario=Success
     *                {"new_data_in_period":6,"latest_data_sent_at":"2021-09-06T22:16:40.000000Z",
     * "latest_data_diff_minutes":4,"possible_problem_detected":false,"server_time":"2021-09-06T22:20:54.430225Z"}
     * @response      status=200 scenario=Error {"new_data_in_period":null,"latest_data_sent_at":"2021-09-06T07:20:54
 * .430225Z",
     * "latest_data_diff_minutes":932,"possible_problem_detected":true,"server_time":"2021-09-06T22:20:54.430225Z"}
     */
    public function getDataStatus(DataStatusRequest $request): JsonResponse
    {
        $periodInMinutes = $request->input('period', self::DEFAULT_CHECK_PERIOD);
        $apiKey = $request->get('api_key')->id;

        $latestDataTime = ServerStat::where('api_key_id', $apiKey)
                ->orderByDesc('created_at')
                ->first()
                ->created_at ?? null;

        $newDataCount = ServerStat::where('created_at', '>',
            now()->subMinutes($periodInMinutes))
            ->where('api_key_id', $apiKey)
            ->count();

        return response()->json([
            'new_data_in_period'        => $newDataCount === 0 ? null : $newDataCount,
            'latest_data_sent_at'       => $latestDataTime,
            'latest_data_diff_minutes'  => $latestDataTime ? now()->diffInMinutes($latestDataTime) : null,
            'possible_problem_detected' => $newDataCount === 0 || is_null($latestDataTime),
            'server_time'               => now(),
        ], JsonResponse::HTTP_OK);
    }
}
