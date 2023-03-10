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
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">$UserName</a>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="sec/logout">Sign out</a>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="$Link">
                            <span data-feather="home"></span>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{$Link}students">
                            <span data-feather="home"></span>
                            Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{$Link}subjects">
                            <span data-feather="file"></span>
                            Subjects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{$Link}users">
                            <span data-feather="file"></span>
                            Users
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="bd-content ps-lg-4">
                <h1 class="h2">Dashboard</h1>
<%--                $UserForm--%>

                <% if $UsersData %>
                    <% include Users %>
                <% end_if %>

                <% if $StudentData %>
                    <% include Students %>
                <% end_if %>

                <% if $SubjectData %>
                    <% include Subjects %>
                <% end_if %>

                <% if $OneStudent %>
                    <% include Student %>
                <% end_if %>

            </div>
        </main>
    </div>
</div>



<script src="$resourceURL('themes/dashboard/dist/js/bootstrap.bundle.min.js')"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
</body>
</html>
