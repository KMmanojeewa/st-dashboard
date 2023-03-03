<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <% base_tag %>

    $MetaTags

    <% require themedCSS('client/styles/debug') %>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <%--    <link rel="stylesheet" type="text/css" href="$resourceURL('themes/bletheme/dist/css/base.css')">--%>
    <%--    <link rel="stylesheet" type="text/css" href="$resourceURL('themes/bletheme/dist/css/app.css')">--%>

</head>
<body>

<div class="page-layout">


    <div class=" d-flex aligns-items-center justify-content-center" style="height:100px; width: 500px; left: 0; margin: auto">
        <div id="root" data-link="$Link">Security page</div>
       <% if $StLogin %>
        $StudentLoginForm
    <% else_if $CreatePassword %>
        $CreatePasswordForm
    <% else_if $LoginWithRegisterNumber %>
           $StudentLoginWithRegisterForm
    <% else_if $StLoginWithPass %>
        $StudentLoginWithPasswordForm
    <% else %>
        $LoginForm
    <% end_if %>
        <br>
        <a href="/welcome"><button type="button" class="btn btn-primary">Go To Welcome</button></a>
    </div>


</div>



    <%--<script src="$resourceURL('themes/bletheme/dist/js/app.min.js')"></script>--%>
    <%--<script src="$resourceURL('themes/bletheme/dist/js/react-app.min.js')"></script>--%>
</body>
</html>
