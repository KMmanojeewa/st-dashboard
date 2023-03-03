<div class="container">
  <div class="row">
    <div class="col">
    <h3>Create Student</h3>
      $StudentForm
    </div>
    <div class="col">
  <% if $AllStudents %>
   <h3>All Students</h3>
 <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Registration Number</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Subjects</th>
    </tr>
  </thead>
  <tbody>

    <% loop $AllStudents %>
    <tr>
      <th scope="row">$ID</th>
      <td>$RegistrationNumber</td>
      <td>$Name</td>
      <td>$Email</td>
      <td><a href="{$Top.Link}student?id={$ID}">Subjects</a></td>
    </tr>
    <% end_loop %>

  </tbody>
</table>

<% else %>
 <p>No student data</p>
<% end_if %>
    </div>
  </div>
</div>

