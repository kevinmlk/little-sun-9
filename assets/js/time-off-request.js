document.querySelector('#employee-select').addEventListener('change', function() {
  let employeeId = document.querySelector('#employee-select').value;

  let formData = new FormData();
  formData.append('employeeId', employeeId);

  fetch('assets/ajax/get-time-off-request.php', {
      method: 'POST',
      body: formData,
  })
  .then(response => response.json())
  .then(result => {
      if (result.status === 'success') {
          // Clear previous options for both employee and task select boxes
          document.querySelector('#period-select').innerHTML = "";
          document.querySelector('#type-select').innerHTML = "";
          console.log(result.body);

          // Loop through employees and create options
          result.body.forEach(employee => {
              // Create option for associated taskname
              let periodOption = document.createElement('option');
              periodOption.value = employee.id;
              periodOption.textContent = employee.period;
              document.querySelector('#period-select').appendChild(periodOption);

              // Create option for associated taskname
              let typeOption = document.createElement('option');
              typeOption.value = employee.type;
              typeOption.textContent = employee.type;
              document.querySelector('#type-select').appendChild(typeOption);
          });
      } else {
          console.log('Error:', result.message);
      }
  })
  .catch(error => {
      console.log('Error:', error);
  });
});
