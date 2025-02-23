document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
    const questionsForm = document.getElementById("questionsForm");
    const resultText = document.getElementById("resultText");

    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const numeroEstudante = document.getElementById("numero_estudante").value;
            const nBi = document.getElementById("n_bi").value;

            fetch("php/auth.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ numero_estudante: numeroEstudante, n_bi: nBi }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        window.location.href = "questions.html";
                    } else {
                        document.getElementById("errorMessage").textContent = data.message;
                    }
                });
        });
    }

    if (questionsForm) {
        fetch("php/get_questions.php")
            .then((response) => response.json())
            .then((data) => {
                const questionsContainer = document.getElementById("questionsContainer");
                data.forEach((question, index) => {
                    const questionDiv = document.createElement("div");
                    questionDiv.innerHTML = `
                        <p>${question.descricao}</p>
                        <label>
                            <input type="radio" name="q${question.id_questao}" value="Sim"> Sim
                        </label>
                        <label>
                            <input type="radio" name="q${question.id_questao}" value="Não"> Não
                        </label>
                    `;
                    questionsContainer.appendChild(questionDiv);
                });
            });

        questionsForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(questionsForm);
            const answers = {};
            formData.forEach((value, key) => {
                answers[key] = value;
            });

            fetch("php/submet_answers.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(answers),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        window.location.href = "result.html";
                    } else {
                        document.getElementById("errorMessage").textContent = data.message;
                    }
                });
        });
    }

    if (resultText) {
        fetch("php/submet_answers.php")
            .then((response) => response.json())
            .then((data) => {
                resultText.textContent = `Sua especialidade elegida é: ${data.especialidade_elegida}`;
            });
    }
});