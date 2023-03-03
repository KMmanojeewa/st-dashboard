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
    <link rel="stylesheet" type="text/css" href="$resourceURL('themes/dashboard/dist/css/bootstrap.min.css')">

</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

</header>

<div class="container-fluid">
    <div class="row">
        <div class=" d-flex aligns-items-center justify-content-center" style="height:100px">
            <a href="/sec/login"><button type="button" class="btn btn-primary">Admin</button></a>
        </div>
        <div class=" d-flex aligns-items-center justify-content-center" style="height:100px">
            <a href="/sec/student-login"><button type="button" class="btn btn-primary">Student</button></a>
        </div>
    </div>
</div>



<script src="$resourceURL('themes/dashboard/dist/js/bootstrap.bundle.min.js')"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>
</html>
