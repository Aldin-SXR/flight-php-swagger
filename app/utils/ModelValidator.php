<?php
define("API_ROOT", realpath(dirname(__FILE__))."/..");

/**
 * ModelValidator class.
 * Class that contains the validation logic for models.
 */
class ModelValidator {
    /**
     * Validate model.
     * Given a class name and passed-in data, determine whether the data model is valid.
     * @param string $class_name Name of the model class.
     * @param array $data Model data being sent.
     * @return array Returns a status array suggesting if the model is valid or invalid (with missing fields).
     */
    public static function validate_model($class_name, $data) {
        $analyser = new \OpenApi\StaticAnalyser();
        $finder = \OpenApi\Util::finder([
            API_ROOT."/models"
        ], null);
        /* Go through all model definitions and validate the request object */
        foreach ($finder as $file) {
            $analysis = $analyser->fromFile($file->getPathname());
            foreach ($analysis->annotations as $annotation) {
                $model = self::extract_property($annotation->_context);
                if (isset($model["name"]) && $model["name"] == $class_name) {
                    if ($annotation->required == true || $annotation->required == "true") {
                        if (!isset($data[$model["property"]]) || $data[$model["property"]] == "") {
                            /* Send out an error message */
                            Flight::json([
                                "error_message" => "Field `".$model["property"]."` is required."
                            ], 400);
                            die;
                        }
                    }
                }
            }
        }
        /* Model is valid */
        return true;
    }
    /**
     * Extract property.
     * Take out a model proprety's name and respetive class name.
     * @param object $context Annotation context passed from OpenApi analyser.
     * @return array Returns a property's name and class. 
     */
    public static function extract_property($context) {
        $value = (string) $context;
        $level1 = explode(" ", $value);
        $level2 = explode("->", $level1[0]);
        if (count($level2) != 2) {
            return NULL;
        }
        return [
            "name" => ltrim($level2[0], "\\"),
            "property" => $level2[1]
        ];
    }
}