<?php

namespace App\Api\v1\Controllers;

use App\Http\Resources\StatisticCollection;
use App\Repository\StatisticRepository;

class StatisticController
{
    /**
     * Statistics all time
     *
     * Get usage statistics of Masternode Health. The data is paginated with max 25 elements per page. Switch the
     * page with the param <code>?page=PAGENUMMER</code>.
     * @group         Statistic
     * @unauthenticated
     * @response      scenario=Success
     *                {"data":{"data":[{"date":"2021-09-14","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-13","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-12","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-11","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-10","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-09","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-08","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-07","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-06","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-05","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-04","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-03","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-02","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-01","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-31","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-30","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-29","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-28","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-27","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-26","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-25","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-24","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-23","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-22","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-08-21","api_key_count":1,"webhook_sent_count":0,"request_received_count":0}]},"links":{"first":"https://api.defichain-masternode-health.com/statistic/all?page=1","last":"https://api.defichain-masternode-health.com/statistic/all?page=2","prev":null,"next":"https://api.defichain-masternode-health.com/statistic/all?page=2"},"meta":{"current_page":1,"from":1,"last_page":2,"path":"https://api.defichain-masternode-health.com/statistic/all","per_page":25,"to":25,"total":30}}
     */
    public function getAll(StatisticRepository $statisticRepository): StatisticCollection
    {
        return new StatisticCollection($statisticRepository::getAll());
    }

    /**
     * Statistics last week
     *
     * Get usage statistics of Masternode Health of the last week.
     * @group         Statistic
     * @unauthenticated
     * @response      scenario=Success
     *                {"data":[{"date":"2021-09-14","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-13","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-12","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-11","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-10","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-09","api_key_count":1,"webhook_sent_count":0,"request_received_count":0},{"date":"2021-09-08","api_key_count":1,"webhook_sent_count":0,"request_received_count":0}]}
     */
    public function getLastWeek(StatisticRepository $statisticRepository): StatisticCollection
    {
        return new StatisticCollection($statisticRepository::lastWeek());
    }
}
