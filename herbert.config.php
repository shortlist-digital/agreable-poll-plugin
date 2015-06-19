<?php


return [

    /**
     * The Herbert version constraint.
     */
    'constraint' => '~0.9.6',

    /**
     * Auto-load all required files.
     */
    'requires' => [
        __DIR__ . '/app/customPostTypes.php',
        __DIR__ . '/app/custom-fields/quiz.php',
        __DIR__ . '/app/hooks/timber_loader_paths.php',
        __DIR__ . '/app/hooks/slm_plugin_enqueue.php'
    ],

    /**
     * Activate
     */
    'activators' => [
        __DIR__ . '/app/activate.php'
    ],

    /**
     * Activate
     */
    'deactivators' => [
        __DIR__ . '/app/deactivate.php'
    ],

    /**
     * The shortcodes to auto-load.
     */
    'shortcodes' => [
        // __DIR__ . '/app/shortcodes.php'
    ],

    /**
     * The widgets to auto-load.
     */
    'widgets' => [
        // __DIR__ . '/app/widgets.php'
    ],

    /**
     * The widgets to auto-load.
     */
    'enqueue' => [
        // __DIR__ . '/app/enqueue.php'
    ],

    /**
     * The routes to auto-load.
     */
    'routes' => [
        // 'SLM_QuizPlugin' => __DIR__ . '/app/routes.php'
    ],

    /**
     * The panels to auto-load.
     */
    'panels' => [
        'SLM_QuizPlugin' => __DIR__ . '/app/panels.php'
    ],

    /**
     * The APIs to auto-load.
     */
    'apis' => [
        // 'SLM_QuizPlugin' => __DIR__ . '/app/api.php'
    ],

    /**
     * The view paths to register.
     *
     * E.G: 'MyPlugin' => __DIR__ . '/views'
     * can be referenced via @MyPlugin/
     * when rendering a view in twig.
     */
    'views' => [
        'SLM_QuizPlugin' => __DIR__ . '/resources/views'
    ],

    /**
     * The view globals.
     */
    'viewGlobals' => [

    ],

    /**
     * The asset path.
     */
    'assets' => '/resources/assets/',

    /**
     * Namespace used in ACF Panel definitions.
     */
    'slm_namespace' => 'slm_quiz',

    /**
     *
     */
    'slm_pluginTitle'      => 'Quiz'
];
