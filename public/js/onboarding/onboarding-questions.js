const onboardingQuestions = [
  {
    id: 1,
    type: "text",
    question: "What is your first name?",
    subtitle:
      "Please provide your first name as it appears on official documents.",
    placeholder: "First Name",
    required: true,
    constraints: {
      minLength: 2,
      maxLength: 50,
    },
  },
  {
    id: 2,
    type: "number",
    question: "What is your gross annual income?",
    subtitle:
      "Please provide your first name as it appears on official documents.",
    placeholder: "Gross Annual Income",
    required: true,
    constraints: {
      min: 10000,
      max: 10000000,
    },
  },
  {
    id: 3,
    type: "select",
    question: "What is your marital status?",
    subtitle:
      "Please provide your first name as it appears on official documents.",
    options: ["Single", "Married", "Divorced", "Widowed"],
    required: true,
  },
  {
    id: 4,
    type: "select",
    question: "Do you have any children?",
    subtitle:
      "Please provide your first name as it appears on official documents.",
    options: ["Yes", "No"],
    required: true,
  },
  {
    id: 5,
    type: "number",
    question: "How many children do you have?",
    subtitle:
      "Please provide your first name as it appears on official documents.",
    placeholder: "Number of Children",
    required: true,
    constraints: {
      min: 0,
      max: 10,
    },
    condition: {
      previousQuestionId: 4,
      requiredAnswer: "Yes",
    },
  },
  {
    id: 6,
    type: "text",
    question: "Answer another thing",
    subtitle:
      "Please provide your first name as it appears on official documents.",
    placeholder: "The placeholder",
    required: true,
    constraints: {
      minLength: 2,
      maxLength: 50,
    },
  },
];
