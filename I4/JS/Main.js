function foodNameFiltering() {
    return new Promise((resolve, reject) => {
        fetch('CBFiltering.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
			.then(response => response.json())
            .then(data => {
                console.log(data);
                foodNameWriteText(data);
                resolve(data);
                
            })
            .catch(error => {
                reject(error);
            });
    });
}

function foodNameWriteText(name) {
    const foodName = document.querySelectorAll('.foodName');
    const foodImageElements = document.querySelectorAll('.foodImage');
    let idx = 0;

    name.forEach(element => {
        foodName[idx].textContent = element.food_name;
        foodImageElements[idx].src = element.file_route ? element.file_route : "./Image/none.png";
        idx++;
    });
}
