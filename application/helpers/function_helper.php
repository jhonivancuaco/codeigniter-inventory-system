<?php

/**
 * Render a page with a given template
 *
 * The page will be rendered with the given template and any data that is passed in
 * will be available to the view.
 *
 * @param string $template The name of the template (without the .php extension)
 * @param string $page The name of the page (without the .php extension)
 * @param array $data An array of data to be passed to the view
 */
function template(string $template, string $page, array $data = []) {
    // generate the path to the template and page views
    $templateView = 'templates/' . $template;
    $pageView     = 'pages/' . $page;

    // generate the full file path to the template and page views
    $templatePath = VIEWPATH . $templateView . '.php';
    $pagePath     = VIEWPATH . $pageView . '.php';

    // if the template view does not exist, show a 404 error
    if (!file_exists($templatePath)) {
        show_error("Template <b>{$template}.php</b> not found", 404);
    }

    // if the page view does not exist, show a 404 error
    if (!file_exists($pagePath)) {
        show_error("Page <b>{$page}.php</b> not found", 404);
    }

    // add the page view to the data array
    $data['page'] = $pageView;

    // load the template view with the data array
    get_instance()->load->view($templateView, $data);
}
