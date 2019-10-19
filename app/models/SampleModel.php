<?php
/**
 * A sample model for the Swagger/OpenAPI specification.
 * Models are used to provide specifications on how API request bodies and reponses should look like.
 * This file can be safely deleted, or edited to suit your models.
 */


/**
 * @OA\Schema(
 * )
 */
class SampleModel {
    /**
     * @OA\Property(
     * description="Sample attribute of the request body. Add the attributes you need in your request body.",
     * required=true,
     * example="A sample string."
     * )
     * @var string
     */
    public $sample_attribute_1;
    /**
     * @OA\Property(
     * description="Sample attribute of the request body. Add the attributes you need in your request body.",
     * required=true,
     * example=42
     * )
     * @var int
     */
    public $sample_attribute_2;
}

/**
 * @OA\Schema(
 * )
 */
class SampleResponse {
    /**
     * @OA\Property(
     * description="Sample success response.",
     * example={}
     * )
     * @var array
     */
    public $success_response;
}

/**
 * @OA\Schema(
 * )
 */
class SampleError {
    /**
     * @OA\Property(
     * description="Sample error response.",
     * )
     * @var string
     */
    public $error_response;
}