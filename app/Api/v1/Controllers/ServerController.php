<?php

namespace App\Api\v1\Controllers;

use App\Api\v1\Requests\ServerRenameRequest;
use App\Api\v1\Resources\ServerCollection;
use App\Repository\ServerRepository;
use App\Service\ServerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServerController
{
    /**
     * List servers
     *
     * Show all servers connected with your API key. Only requires the <code>x-api-key</code> header data.
     * @group     Server
     * @header    x-api-key bffd1dfd-63b8-48f2-afe6-f4318cce86ef
     * @response  scenario=Success {"data":[{"name":"Party server","server_id":"00ebd742-8c6b-4a64-af43-c8942530c444",
     * "created_at":"2021-07-18T19:23:31.000000Z"},{"name":"My awesome 2nd server",
     * "server_id":"063e8f8b-1eba-4741-82ec-608319c92705","created_at":"2021-08-11T05:44:45.000000Z"}],"info":{"count":2}}
     */
    public function listServers(Request $request, ServerRepository $repository): ResourceCollection
    {
        return new ServerCollection($repository->getServersForApiKey($request->input('api_key')));
    }

    /**
     * Rename server
     *
     * Rename a already setup server key. Requires <code>x-api-key</code> and <code>x-server-key</code> header data.
     * @bodyParam name sring required Example: My Awesome Server
     * @group     Server
     * @header    x-api-key bffd1dfd-63b8-48f2-afe6-f4318cce86ef
     * @header    x-server-key 05dbded5-0084-40e1-ab4d-064859440369
     * @response  scenario=Success {"message":"server \"05dbded5-0084-40e1-ab4d-064859440369\" renamed"}
     */
    public function renameServer(ServerRenameRequest $request, ServerService $serverService): JsonResponse
    {
        /** @var \App\Models\Server $server */
        $server = $request->get('server');
        $serverService->rename($server, $request->name());

        return response()->json([
            'message' => sprintf('server "%s" renamed', $server->id),
        ]);
    }

    /**
     * Delete Server
     *
     * Delete and remove all data for the server given with the <code>x-server-key</code> inside the header data
     * @header    x-api-key bffd1dfd-63b8-48f2-afe6-f4318cce86ef
     * @header    x-server-key 05dbded5-0084-40e1-ab4d-064859440369
     * @group Server
     */
    public function deleteServer(Request $request, ServerService $serverService): JsonResponse
    {
        $serverId = $request->get('server')->id;
        $serverService->delete($request->get('server'));

        return response()->json([
            'message' => sprintf('server with id %s deleted', $serverId),
        ]);
    }
}
