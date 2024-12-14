async function getData() {
    const url = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        populateTable(data.results); // Call to populate the table with the fetched data Call for table population with data that was fetched
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

function populateTable(data) {
    const tableBody = document.querySelector("#student-data-table tbody");
    data.forEach(item => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${item.year}</td>
            <td>${item.semester}</td>
            <td>${item.the_programs}</td>
            <td>${item.nationality}</td>
            <td>${item.colleges}</td>
            <td>${item.number_of_students}</td>
        `;
        tableBody.appendChild(row);
    });
}

getData();
