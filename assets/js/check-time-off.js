document.querySelector('#start-time').addEventListener('change', function() {
  let employeeId = document.querySelector('#employee-select').value;
  let startTime = document.querySelector('#start-time').value;

  let formData = new FormData();
  formData.append('employeeId', employeeId);
  formData.append('startTime', startTime);

  fetch('assets/ajax/check-time-off.php', {
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
              taskOption.value = employee.Status;
              taskOption.textContent = employee.Status;
              document.querySelector('#task-select').appendChild(taskOption);
              console.log(employee.Status);
            });
      } else {
          console.log('Error:', result.message);
      }
  })
  .catch(error => {
      console.log('Error:', error);
  });
});
