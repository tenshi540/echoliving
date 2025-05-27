document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("product-search");
  const container   = document.getElementById("product-list");
  let debounceTimer;

  // Cart helpers
  const getCart = () => JSON.parse(localStorage.getItem("cart")) || {};
  const saveCart = cart => localStorage.setItem("cart", JSON.stringify(cart));
  const updateCartCount = () => {
    const cart = getCart();
    const total = Object.values(cart).reduce((sum, n) => sum + n, 0);
    const el = document.getElementById("cart-count");
    if (!el) return;
    el.textContent = total;
    el.classList.add("bump");
    setTimeout(() => el.classList.remove("bump"), 150);
  };

  // Render function used by both initial load and search
  function renderProducts(products) {
    // group by category
    const byCat = products.reduce((acc, p) => {
      const cat = p.category || "uncategorized";
      (acc[cat] = acc[cat] || []).push(p);
      return acc;
    }, {});

    container.innerHTML = "";

    Object.entries(byCat).forEach(([cat, items]) => {
      // Section wrapper
      const section = document.createElement("section");
      section.className = "category-section";

      // Header with arrow
      const header = document.createElement("h2");
      header.className = "category-header";
      header.innerHTML = `
        <span class="arrow">▼</span>
        ${cat.charAt(0).toUpperCase() + cat.slice(1)}
      `;
      section.appendChild(header);

      // Grid of product cards
      const grid = document.createElement("div");
      grid.className = "category-grid product-list";

      items.forEach(p => {
        const card = document.createElement("div");
        card.className = "product-card";
        card.innerHTML = `
          <img
            src="/echoliving/frontend/res/img/${p.image_filename}"
            alt="${p.name}"
            class="product-img"
          />
          <h3>${p.name}</h3>
          <p>${p.description}</p>
          <p>Rating: ${p.rating} ⭐</p>
          <p><strong>€${parseFloat(p.price).toFixed(2)}</strong></p>
          <button class="add-to-cart" data-id="${p.id}">Add to Cart</button>
        `;
        grid.appendChild(card);
      });

      section.appendChild(grid);
      container.appendChild(section);
    });

    // Initialize badge
    updateCartCount();
  }

  // Fetch and render all products initially
  fetch("/echoliving/backend/logic/loadProducts.php")
    .then(r => r.json())
    .then(renderProducts)
    .catch(err => {
      console.error("Error loading products:", err);
      container.innerHTML = "<p>Failed to load products.</p>";
    });

  // Live search handler (strict JSON, POST only)
searchInput.addEventListener("input", e => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    const term = e.target.value.trim();
    if (term === "") {
      // If search bar is empty, reload all products
      fetch("/echoliving/backend/logic/loadProducts.php")
        .then(r => r.json())
        .then(renderProducts)
        .catch(err => {
          console.error("Error loading products:", err);
          container.innerHTML = "<p>Failed to load products.</p>";
        });
    } else {
      fetch("/echoliving/backend/logic/searchProducts.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ q: term })
      })
        .then(r => r.json())
        .then(renderProducts)
        .catch(err => {
          console.error("Search error:", err);
        });
    }
  }, 300);
});


  // Event delegation for Add-to-Cart and collapse/expand
  container.addEventListener("click", e => {
    // Add to Cart
    if (e.target.matches(".add-to-cart")) {
      const id = e.target.dataset.id;
      const cart = getCart();
      cart[id] = (cart[id] || 0) + 1;
      saveCart(cart);
      updateCartCount();
    }

    // Collapse/expand category
    const header = e.target.closest(".category-header");
    if (header) {
      const grid = header.nextElementSibling;
      const collapsed = grid.classList.toggle("collapsed");
      header.classList.toggle("collapsed", collapsed);
    }
  });
});
