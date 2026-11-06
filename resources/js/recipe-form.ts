const button = document.getElementById('add-ingredient') as HTMLButtonElement | null;
const container = document.getElementById('ingredient-rows') as HTMLDivElement | null;

if (button && container) {
    button.addEventListener('click', () => {
        const rows = container.querySelectorAll<HTMLDivElement>('.ingredient-row');
        const nextIndex = rows.length;
        const newRow = rows[rows.length - 1].cloneNode(true) as HTMLDivElement;

        newRow.querySelectorAll<HTMLInputElement>('input').forEach((input) => {
            input.value = '';
            input.name = input.name.replace(/ingredients\[\d+\]/, `ingredients[${nextIndex}]`);
        });

        container.appendChild(newRow);
    });
}