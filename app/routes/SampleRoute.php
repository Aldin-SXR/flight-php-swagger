<?php

/**
 * Sample Flight endpoints for demonstrating Flight and Swagger functionalities.
 * This file can be safely removed, or edited to suit your project needs.
 */

/**
 * @OA\Get(
 *      path="/sample/",
 *      tags={"sample"},
 *      summary="Sample endpoint to test the functionality of Flight and Swagger. ",
 *      @OA\Response(
 *          response=200,
 *          description="A sample response."
 *      )
 * )
 */
Flight::route('GET /sample/', function () {
    Flight::json(['sample_route' => 'Sample response.']);
});

/**
 * @OA\Post(
 *      path="/sample/{path_param}",
 *      tags={"sample"},
 *      summary="Sample endpoint to test the functionality of Flight and Swagger. ",
 *      @OA\Parameter(
 *          name="path_param",
 *          in="path",
 *          required=true,
 *          description="Sample path parameter.",
 *          @OA\Schema(
 *              type="string",
 *              default="1"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          description="Sample request body.",
 *          @OA\JsonContent(ref="#/components/schemas/SampleModel")
 *       ),
 *      @OA\Response(
 *           response=200,
 *           description="Sample success response.",
 *          @OA\JsonContent(ref="#/components/schemas/SampleResponse")
 *      ),
 *      @OA\Response(
 *           response=400,
 *           description="Sample error response.",
 *          @OA\JsonContent(ref="#/components/schemas/SampleError")
 *      ),
 *     security={
 *          {"api_key": {}}
 *      }
 * )
 */
Flight::route('POST /sample/@path_param', function ($id) {
    $data = Flight::request()->data->getData();
    /* Pass in a data object for model validation; if invalid, the request will terminate. */
    Flight::validate(SampleModel::class, $data);
    Flight::json([
        "success_response" => array_merge(
            ['path_param' => $id],
            $data
        )
    ]);
});
