<?php
/* Project configuration */
require_once __DIR__ . '/../config/config.php';
?>

<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo PROJECT_DOCS_TITLE ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo DOCS_FOLDER ?>/swagger-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo DOCS_FOLDER ?>/custom-swagger.css">
    <link rel="icon" type="image/png" href="<?php echo DOCS_FOLDER ?>/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo DOCS_FOLDER ?>/favicon-16x16.png" sizes="16x16" />
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            background: #fafafa;
        }
    </style>
</head>

<body>
    <div id="swagger-ui"></div>

    <script src="<?php echo DOCS_FOLDER ?>/swagger-ui-bundle.js"> </script>
    <script src="<?php echo DOCS_FOLDER ?>/swagger-ui-standalone-preset.js"> </script>
    <script>
        window.onload = function () {
            // Begin Swagger UI call region
            const ui = SwaggerUIBundle({
                url: "<?php echo DOCS_FOLDER ?>/swagger.json",
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout"
            })
            // End Swagger UI call region

            window.ui = ui
        }
    </script>
</body>

</html>