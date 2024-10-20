function populateCards(cards) {
  const dashboardCardsContainer = document.getElementById("dashboardCards");

  cards.forEach((card) => {
    const colDiv = document.createElement("a");
    colDiv.className = "col-6 col-lg-3 d-flex no-decoration";
    colDiv.href = card.href;

    const cardDiv = document.createElement("div");
    cardDiv.className = "card p-3 flex-fill";

    const cardTitle = document.createElement("small");
    cardTitle.className = "card-title fw-bold";
    cardTitle.textContent = card.title.toUpperCase();

    const cardAmount = document.createElement("p");
    cardAmount.className = "card-amount fs-3";
    cardAmount.textContent = card.amount;

    const cardSubtitle = document.createElement("small");
    cardSubtitle.className = "card-subtitle fw-light";
    cardSubtitle.textContent = card.subtitle;

    cardDiv.appendChild(cardTitle);
    cardDiv.appendChild(cardAmount);
    cardDiv.appendChild(cardSubtitle);

    colDiv.appendChild(cardDiv);

    dashboardCardsContainer.appendChild(colDiv);
  });
}

function addCard(card) {
  const dashboardCardsContainer = document.getElementById("dashboardCards");

  const colDiv = document.createElement("a");
  colDiv.className = "col-6 col-lg-3 d-flex no-decoration";
  colDiv.href = card.href;

  const cardDiv = document.createElement("div");
  cardDiv.className = "card p-3 flex-fill";

  const cardTitle = document.createElement("small");
  cardTitle.className = "card-title fw-bold";
  cardTitle.textContent = card.title.toUpperCase();

  const cardAmount = document.createElement("p");
  cardAmount.className = "card-amount fs-3";
  cardAmount.textContent = card.amount;

  const cardSubtitle = document.createElement("small");
  cardSubtitle.className = "card-subtitle fw-light";
  cardSubtitle.textContent = card.subtitle;

  cardDiv.appendChild(cardTitle);
  cardDiv.appendChild(cardAmount);
  cardDiv.appendChild(cardSubtitle);

  colDiv.appendChild(cardDiv);

  dashboardCardsContainer.appendChild(colDiv);
}

if (typeof cardData !== 'undefined' && cardData !== null) {
  populateCards(cardData);
}
