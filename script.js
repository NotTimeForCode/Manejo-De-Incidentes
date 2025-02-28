document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.incident_selector');
    const form = document.querySelector('form[name="incident_form"]');
    const hostnameField = form.querySelector('input[name="hostname"]');
    const userField = form.querySelector('input[name="user"]');
    const incidentIdField = form.querySelector('input[name="incident_id"]');
    const incidentField = form.querySelector('input[name="incident"]');
    const logTimeField = form.querySelector('input[name="log_time"]');
    const detailsField = form.querySelector('textarea[name="details"]');

    function updateFormFields(button) {
        const incidentId = button.getAttribute('data-incident-id');
        const hostname = button.getAttribute('data-hostname');
        const user = button.getAttribute('data-user');
        const incident = button.getAttribute('data-incident');
        const logTime = button.getAttribute('data-log-time');

        // Update form fields with incident data
        hostnameField.value = hostname;
        userField.value = user;
        incidentIdField.value = incidentId;
        incidentField.value = incident;
        logTimeField.value = logTime;
        detailsField.value = '';

        // Update display fields with incident data
        document.getElementById('data1').textContent = `nombre de host: ${hostname}`;
        document.getElementById('data2').textContent = `nombre del usuario: ${user}`;
        document.getElementById('data3').textContent = `número de incidente: ${incidentId}`;
        document.getElementById('data4').textContent = `información sobre el incidente: ${incident}`;
        document.getElementById('data5').textContent = `Hora en que se registró el incidente: ${logTime}`;
    }

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            updateFormFields(this);
        });
    });

    // Automatically select the first incident button when the page loads
    if (buttons.length > 0) {
        updateFormFields(buttons[0]);
    }
});