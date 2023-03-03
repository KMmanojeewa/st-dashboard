<div class="container">
<h3>Student {$Student.Name}</h3>
</div>
<div class="container">
  <div class="row">
    <div class="col">
    <h3>Add Marks</h3>
      $MarksForm
    </div>
    <div class="col">
  <% if $StudentSubjects %>
   <h3>Student Subjects</h3>
 <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Mark</th>
    </tr>
  </thead>
  <tbody>

    <% loop $StudentSubjects %>
    <tr>
      <th scope="row">$ID</th>
      <td>$Name</td>
      <td>$Marks</td>
    </tr>
    <% end_loop %>

  </tbody>
</table>

<% else %>
 <p>No student subjects</p>
<% end_if %>
    </div>
  </div>
</div>

