document.querySelector('#hub-select').addEventListener('change', function() {
  let locationId = document.querySelector('#hub-select').value;

  let formData = new FormData();
  formData.append('LocationId', locationId);

  fetch('assets/ajax/get-employees.php', {
      method: 'POST',
      body: formData,
  })
  .then(response => response.json())
  .then(result => {
      if (result.status === 'success') {
          // Clear previous options for both employee and task select boxes
          document.querySelector('#employee-select').innerHTML = "";
          document.querySelector('#task-select').innerHTML = "";

          // Loop through employees and create options
          result.body.forEach(employee => {
              let employeeOption = document.createElement('option');
              employeeOption.value = employee.Id;
              employeeOption.textContent = employee.Firstname + ' ' + employee.Lastname;
              document.querySelector('#employee-select').appendChild(employeeOption);

              // Create option for associated taskname
              let taskOption = document.createElement('option');
              taskOption.value = employee.Taskname;
              taskOption.textContent = employee.Taskname;
              document.querySelector('#task-select').appendChild(taskOption);
          });
      } else {
          console.log('Error:', result.message);
      }
  })
  .catch(error => {
      console.log('Error:', error);
  });
});
