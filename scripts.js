document.addEventListener("DOMContentLoaded", function() {
    // Aquí harías una llamada AJAX para obtener los productos de la base de datos
    const products = [
        { id: 1, nombre: 'Café Americano', descripcion: 'Café negro', precio: 2.50 },
        { id: 2, nombre: 'Café Latte', descripcion: 'Café con leche', precio: 3.50 }
    ];

    const productList = document.getElementById('product-list');
    
    products.forEach(product => {
        const productElement = document.createElement('div');
        productElement.innerHTML = `
            <h3>${product.nombre}</h3>
            <p>${product.descripcion}</p>
            <p>Precio: $${product.precio.toFixed(2)}</p>
        `;
        productList.appendChild(productElement);
    });
});
