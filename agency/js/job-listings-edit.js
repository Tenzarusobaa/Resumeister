        function editJobTitle(jobListingId) {
            const value = document.getElementById(`JobTitleValue-${jobListingId}`);
            const input = document.getElementById(`JobTitleInput-${jobListingId}`);
            if (input.style.display === 'none') {
                value.style.display = 'none';
                input.style.display = 'block';
            } 
            else {
                value.style.display = 'block';
                input.style.display = 'none';
            }
        }

        function editJobLocation(jobListingId) {
            const value = document.getElementById(`JobLocationValue-${jobListingId}`);
            const input = document.getElementById(`JobLocationInput-${jobListingId}`);
            if (input.style.display === 'none') {
                value.style.display = 'none';
                input.style.display = 'block';
            } 
            else {
                value.style.display = 'block';
                input.style.display = 'none';
            }
        }

        function editJobDetails(jobListingId) {
            const value = document.getElementById(`JobDetailsValue-${jobListingId}`);
            const input = document.getElementById(`JobDetailsInput-${jobListingId}`);
            if (input.style.display === 'none') {
                value.style.display = 'none';
                input.style.display = 'block';
            } else {
                value.style.display = 'block';
                input.style.display = 'none';
            }
        }

       function editResponsibilities(jobListingId) {
    const value = document.getElementById(`ResponsibilitiesValue-${jobListingId}`);
    const input = document.getElementById(`ResponsibilitiesInput-${jobListingId}`);
    console.log('value element:', value);
    console.log('input element:', input);
    if (input && input.style.display === 'none') {
        value.style.display = 'none';
        input.style.display = 'block';
    } else if (input) {
        value.style.display = 'block';
        input.style.display = 'none';
    }
}

function editQualifications(jobListingId) {
    const value = document.getElementById(`QualificationsValue-${jobListingId}`);
    const input = document.getElementById(`QualificationsInput-${jobListingId}`);
    console.log('value element:', value);
    console.log('input element:', input);
    if (input && input.style.display === 'none') {
        value.style.display = 'none';
        input.style.display = 'block';
    } else if (input) {
        value.style.display = 'block';
        input.style.display = 'none';
    }
}


function testopen() {
    const open = document.getElementById('test');
    open.style.display = 'block'
}
