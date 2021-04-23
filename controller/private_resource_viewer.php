
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!-- Gallery -->

<?php


$privates = array();

echo display($privates);

function display($array)
{
    $string = /** @lang text */
        '<div class="container">';

    $string .= /** @lang text */
        '<div class="alert alert-danger">
<strong>Warning!</strong> The following resources seem to have private access IPs and wont be displayed on public domains. <p>Should you wish to continue?</>.
</div>';
    $string .= /** @lang text */
        '<div class="row">';

    for ($i = 0; $i < 15; $i++) {
        $string .= /** @lang text */
            '<div class="col-lg-3 col-md-4 col-sm-6">';
        $string .= /** @lang text */
            ' <img src="https://dummyimage.com/160x120/000000/fff.png&text=Photo+' . $i . '" class="img-thumbnail my-3">';

        $string .= '<p>private url</p>';
        $string .= /** @lang text */
            '</div>';
    }

    $string .= /** @lang text */
        '</div>';
    $string .= /** @lang text */
        '</div>';


    return $string;
}

?>