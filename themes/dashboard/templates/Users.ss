
<div class="container">
  <div class="row">
    <div class="col">
    <h3>Create User</h3>
        $UserForm
    </div>
    <div class="col">
  <% if $AllUsers %>
   <h3>All Users</h3>
 <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>

    <% loop $AllUsers %>
    <tr>
      <th scope="row">$ID</th>
      <td>$Name</td>
      <td>$Email</td>
    </tr>
    <% end_loop %>

  </tbody>
</table>

<% else %>
 <p>No users</p>
<% end_if %>
    </div>
  </div>
</div>

