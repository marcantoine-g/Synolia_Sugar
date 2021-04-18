let token = "157a678f-3d81-37cc-bdb4-966680bf9cd5";

const url =
  "https://api.insee.fr/entreprises/sirene/V3/siren?q=periode(denominationUniteLegale%3A%22Synolia%22)";

const options = {
  headers: {
    Accept: "application/json",
    Authorization: "Bearer " + token,
  },
};

fetch(url, options)
  .then((response) => {
    response.json().then((resp) => {
      const unitesLegales = resp?.unitesLegales[0];
      appendData(unitesLegales);
    });
  })
  .catch((error) => {
    console.log("FETCHING ERROR");
    console.error(error);
  });

function appendData(data) {
  const container = document.getElementById("container");
  data?.periodesUniteLegale.forEach((periode) => {
    let newDiv = document.createElement("div");
    newDiv.innerHTML =
      "Début : " +
      periode.dateDebut +
      " | Fin : " +
      periode.dateFin +
      " | Activité principale : " +
      periode.activitePrincipaleUniteLegale +
      "<br/>";
    container.appendChild(newDiv);
  });
}
