const elements = document.getElementsByName("fullElements");
const elementsToHide = document.getElementsByName("paginationElements");

function searchCadena(searchElement) {
    elementsToHide.forEach((row)=> {
        row.classList.add("hidden");
    });
    if (!searchElement == "") {
        elements.forEach((row) => {
            row.classList.add("hidden");
        });
        elements.forEach((tr) => {
            tr.childNodes.forEach((td) => {
                if ((td.textContent).toLowerCase().includes(searchElement.toLowerCase())) {
                    tr.classList.remove("hidden");
                }
            });
        });
    } else {
        elements.forEach((row) => {
            row.classList.add("hidden");
        });

        elementsToHide.forEach((row)=> {
            row.classList.remove("hidden");
        });
    }
}
