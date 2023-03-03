<div class="container">
  <div class="row">
    <div class="col">
    <h3>Create Subject</h3>
      $SubjectForm
    </div>
    <div class="col">
  <% if $AllSubjects %>
   <h3>All Subjects</h3>
 <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
    </tr>
  </thead>
  <tbody>

    <% loop $AllSubjects %>
    <tr>
      <th scope="row">$ID</th>
      <td>$Name</td>
    </tr>
    <% end_loop %>

  </tbody>
</table>

<% else %>
 <p>No subjects found</p>
<% end_if %>
    </div>
  </div>
</div>

