document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#incident_form');
    const buttons = document.querySelectorAll('.incident_selector');
    const hostnameField = form.querySelector('input[name="hostname"]');
    const userField = form.querySelector('input[name="user"]');
    const incidentIdField = form.querySelector('input[name="incident_id"]');
    const incidentField = form.querySelector('input[name="incident"]');
    const logTimeField = form.querySelector('input[name="log_time"]');
    const detailsField = form.querySelector('textarea[name="details"]');
    const incidentStatusField = form.querySelector('input[name="incident_status"]');
    const selectedIncidentIdField = form.querySelector('#selected_incident_id');
    const feedbackField = form.querySelector('#feedback');
    let previousButton = null;

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
        selectedIncidentIdField.value = incidentId;

        // Update display fields with incident data
        document.getElementById('data1').textContent = `nombre de host: ${hostname}`;
        document.getElementById('data2').textContent = `nombre del usuario: ${user}`;
        document.getElementById('data3').textContent = `número de incidente: ${incidentId}`;
        document.getElementById('data4').textContent = `información sobre el incidente: ${incident}`;
        document.getElementById('data5').textContent = `Hora en que se registró el incidente: ${logTime}`;
    }

    function highlighter(button) {
        if (previousButton) {
            previousButton.style.backgroundColor = ''; // Reset previous button background color
            previousButton.style.border = ''; // Reset previous button background color

            // Reset previous button text color based on incident status
            const previousIncidentStatus = previousButton.getAttribute('data-incident-status');
            if (previousIncidentStatus === 'Neutral') {
                previousButton.style.color = 'white';
            } else if (previousIncidentStatus === 'In process') {
                previousButton.style.color = 'black';
            } else {
                previousButton.style.color = ''; // Default color
            }
        }

        const buttonStatus = button.getAttribute('data-incident-status');
        if (buttonStatus === 'In process') {
            button.style.border = '2px dashed black'; // Set new button background color
        }

        button.style.backgroundColor = 'lightblue'; // Set new button background color
        button.style.color = 'black'; // Set new button text color
        previousButton = button; // Update previous button reference
    }

    function updateURLParameter(param, value) {
        const url = new URL(window.location);
        url.searchParams.set(param, value);
        window.history.replaceState({}, '', url);
    }

    function updateFormAction() {
        const selectedIncidentId = selectedIncidentIdField.value;
        const url = new URL(window.location);
        if (selectedIncidentId) {
            url.searchParams.set('selected_incident_id', selectedIncidentId);
        }
        form.action = url.toString();
    }

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            updateFormFields(this);
            highlighter(this);
            updateURLParameter('selected_incident_id', this.getAttribute('data-incident-id'));
        });
    });

    // Automatically select the previously selected incident button when the page loads
    const selectedIncidentId = selectedIncidentIdField.value;

    if (selectedIncidentIdField.value) {
        const selectedButton = document.querySelector(`.incident_selector[data-incident-id="${selectedIncidentId}"]`)
        if (selectedButton) {
            console.log('program worked');
            updateFormFields(selectedButton);
            highlighter(selectedButton);
        }
    } else if (buttons.length > 0) {
        console.log('program didnt work');
        updateFormFields(buttons[0]);
        highlighter(buttons[0]);
    }

    // Handle form submission for "Concluir incidente"
    document.querySelector('.form_button.concluir').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission
        incidentStatusField.value = 'Concluded';
        feedbackField.value = detailsField.value; // Set feedback value
        detailsField.setAttribute('name', 'details'); // Ensure details field is included
        updateFormAction();
        form.submit();
    });

    // Handle form submission for "En proceso"
    document.querySelector('.form_button.proceso').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission
        incidentStatusField.value = 'In process';
        feedbackField.value = ''; // Clear feedback value
        detailsField.removeAttribute('name'); // Remove details field from form
        updateFormAction();
        form.submit(); // Manually submit the form
    });

    document.querySelector('.form_button.neutral').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission
        incidentStatusField.value = 'Neutral';
        feedbackField.value = ''; // Clear feedback value
        detailsField.removeAttribute('name'); // Remove details field from form
        updateFormAction();
        form.submit(); // Manually submit the form
    });

    // Re-add the details field name when the form is submitted for "Concluir incidente"
    form.addEventListener('submit', function(event) {
        if (incidentStatusField.value === 'Concluded') {
            detailsField.setAttribute('name', 'details');
        }
    });
});