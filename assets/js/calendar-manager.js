document.querySelector('#employee-select').addEventListener('change', function() {
  let employeeId = document.querySelector('#employee-select').value;

  let formData = new FormData();
  formData.append('employeeId', employeeId);

  fetch('assets/ajax/get-task.php', {
      method: 'POST',
      body: formData,
  })
  .then(response => response.json())
  .then(result => {
      if (result.status === 'success') {
          // Clear previous options for both employee and task select boxes
          document.querySelector('#task-select').innerHTML = "";

          // Loop through employees and create options
          result.body.forEach(employee => {
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
