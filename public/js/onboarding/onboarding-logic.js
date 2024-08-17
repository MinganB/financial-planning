let currentQuestionIndex = 0;

/**
 * Display question (currentQuestionIndex) to the user.
 */
function displayCurrentQuestion() {
  const questionContainer = document.getElementById(
    "onboarding-step-container"
  );
  const questionData = onboardingQuestions[currentQuestionIndex];
  let inputField = "";

  const previousAnswer = questionData.answer || "";

  if (questionData.type === "text") {
    inputField = `<input type="text" id="answer" placeholder="${questionData.placeholder}" value="${previousAnswer}" required="${questionData.required}" minlength="${questionData.constraints.minLength}" maxlength="${questionData.constraints.maxLength}" />`;
  } else if (questionData.type === "number") {
    inputField = `<input type="number" id="answer" placeholder="${questionData.placeholder}" value="${previousAnswer}" required="${questionData.required}" min="${questionData.constraints.min}" max="${questionData.constraints.max}" />`;
  } else if (questionData.type === "select") {
    inputField = '<select id="answer">';
    questionData.options.forEach((option) => {
      const selected = option === previousAnswer ? "selected" : "";
      inputField += `<option value="${option}" ${selected}>${option}</option>`;
    });
    inputField += "</select>";
  }

  questionContainer.innerHTML =
    `
      <div class="question">
          <h2 class="inter-medium mb-2">${questionData.question}</h2>
          ${
            questionData.subtitle
              ? `<div class="text-muted inter-light mb-4 mt-0">${questionData.subtitle}</div>`
              : ""
          }
          <div id="error-message" class="text-danger mb-2 inter-ultra-light"></div>
          ${inputField}
      </div>
      <div class="navigation-buttons">
          <div class="d-flex justify-content-end">
              <button onclick="nextQuestion()" class="btn btn-primary"><img class="icon-18 pb-1 mobile-hidden" src="` +
    url_enter_img +
    `"> Continue</button>
          </div>
      </div>
  `;

  let backBtn = document.getElementById("btn-previous-question");
  if (currentQuestionIndex > 0) backBtn.style.visibility = "visible";
  else backBtn.style.visibility = "hidden";

  let skipBtn = document.getElementById("btn-skip-question");
  if (currentQuestionIndex >= onboardingQuestions.length - 1)
    skipBtn.style.visibility = "hidden";
  else skipBtn.style.visibility = "visible";

  updateProgressBar();
  document.getElementById("answer").focus();
}

/**
 * Go to next question in set.
 */
function nextQuestion() {
  const answerElement = document.getElementById("answer");
  const answer = answerElement.value;
  const questionData = onboardingQuestions[currentQuestionIndex];
  const errorMessageElement = document.getElementById("error-message");

  // Reset error state
  errorMessageElement.innerText = "";
  answerElement.classList.remove("is-invalid");

  // Check required fields and constraints
  if (questionData.required && !answer) {
    errorMessageElement.innerText = "This field is required.";
    answerElement.classList.add("is-invalid");
    return;
  }

  if (questionData.type === "number") {
    const numericAnswer = parseFloat(answer);
    if (
      numericAnswer < questionData.constraints.min ||
      numericAnswer > questionData.constraints.max
    ) {
      errorMessageElement.innerText = `Please enter a value between ${questionData.constraints.min} and ${questionData.constraints.max}.`;
      answerElement.classList.add("is-invalid");
      return;
    }
  }

  // Save answer
  onboardingQuestions[currentQuestionIndex].answer = answer;

  do {
    currentQuestionIndex++;

    // Confirm if at the end of the questions
    if (currentQuestionIndex >= onboardingQuestions.length) {
      // TODO: Send data to server
      alert("Onboarding complete!"); // Finish onboarding process
      console.log(onboardingQuestions); // Output the answers for now

      let success = true;

      if (!success) {
        // TODO: Show an error message
        return;
      }

      window.location.href = base_url + "me/onboarding/complete";
    }

    // Conditional questions
    const nextQuestionData = onboardingQuestions[currentQuestionIndex];
    if (nextQuestionData.condition) {
      const prevAnswer = onboardingQuestions.find(
        (q) => q.id === nextQuestionData.condition.previousQuestionId
      ).answer;

      // Skip the question if the condition is not met
      if (prevAnswer !== nextQuestionData.condition.requiredAnswer) {
        continue;
      }
    }

    break;
  } while (true);

  displayCurrentQuestion();
}

/**
 * Go back a question.
 */
function previousQuestion() {
  do {
    if (currentQuestionIndex > 0) {
      currentQuestionIndex--;

      // Handle conditionals when going back
      const previousQuestionData = onboardingQuestions[currentQuestionIndex];
      if (previousQuestionData.condition) {
        const prevAnswer = onboardingQuestions.find(
          (q) => q.id === previousQuestionData.condition.previousQuestionId
        ).answer;

        // Skip question if condition is not met
        if (prevAnswer !== previousQuestionData.condition.requiredAnswer) {
          continue;
        }
      }

      break;
    }
  } while (true);

  displayCurrentQuestion();
}

/**
 * Call to update progress bar based on current question index
 */
function updateProgressBar() {
  const progress =
    ((currentQuestionIndex + 1) / onboardingQuestions.length) * 100;
  document.getElementById("progressBar").style.width = `${progress}%`;
}

document.addEventListener("DOMContentLoaded", function () {
  displayCurrentQuestion();
});

/**
 * Proceed to next question on Enter key
 */
document.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    event.preventDefault();
    nextQuestion();
  }
});
