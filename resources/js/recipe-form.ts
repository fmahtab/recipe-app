const button = document.getElementById('add-ingredient') as HTMLButtonElement | null;
const container = document.getElementById('ingredient-rows') as HTMLDivElement | null;
const ingredient = document.getElementById('ingredient-template') as HTMLTemplateElement | null;

if (button && container) {
    button.addEventListener('click', () => {
        const rows = container.querySelectorAll<HTMLDivElement>('.ingredient-row');
        if(ingredient){
            const newRow = ingredient.content.cloneNode(true) as DocumentFragment;
            const nextIndex = rows.length;
            
            newRow.querySelectorAll<HTMLInputElement>('input').forEach((input) => {
                input.value = '';
                input.name = `ingredients[${nextIndex}][${input.dataset.field ?? ''}]`;
            });

            container.appendChild(newRow);
        }
    });
}