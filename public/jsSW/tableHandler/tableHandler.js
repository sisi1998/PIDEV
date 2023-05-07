
const table = document.querySelector('.equipesGrid');
const tableContent = table.querySelector('.equipeGridContent');
const selector = document.querySelector('#competition_equipes');
const options = selector.querySelectorAll('option');
table.style.display = 'none';
function generateTemplate(option) {
    var element = document.createElement('tr');
    element.innerHTML = `
		<th scope="row">
			<div class="media align-items-center">
				<a href="#" class="avatar rounded-circle mr-3">
					<img alt="Image placeholder" src="https://raw.githack.com/creativetimofficial/argon-dashboard/master/assets/img/theme/bootstrap.jpg">
				</a>
				<div class="media-body">
					<span class="mb-0 text-sm">${option.innerHTML}</span>
				</div>
			</div>
		</th>
		<td>
            ${option.value}
		</td>`;
    return element;
}

selector.addEventListener('click', (event) => {
    // console.log(event);
    // const name = event.target.innerHTML;
    // const id = event.target.value;
    // console.log('we selected :', name, ' and with id: ', id);
    // console.log('options', event.target.selected);
    // console.log(options);
    const selectedOptions = [];
    tableContent.innerHTML= '';
    options.forEach((option) => {
        if (!!option.selected) {
            selectedOptions.push(option);
        }
    });
    selectedOptions.forEach((selectedOption) => {
        const template = generateTemplate(selectedOption);
        console.log(template);
        tableContent.appendChild(template);
    });
    if (!!selectedOptions.length) {
        table.style.display = 'block';
    }
    else {
        table.style.display = 'none';
    }
});

console.log(selector.value);
console.log(table);