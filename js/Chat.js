//Para guardar lo que contenga el textarea
const chatInput = document.querySelector(".chat-input textarea");
//Enviar el mensaje
const enviar = document.querySelector(".chat-input span");
//Lo muestra en la pantalla el mensaje enviado y recibido
const chatbox = document.querySelector(".chatbox");
//Abrir y cerrar el chat en computadora
const chatbotToggler = document.querySelector(".chatbot-toggler");
//Para cerrar el chat en telefono
const chatbotClose = document.querySelector(".close-btn");

let mensaje;

const inputInitHeight = chatInput.scrollHeight;

//Función para agregar mensajes al chat
const addMessage = (mensaje, className) => {
  const chatLi = document.createElement("li");
  chatLi.classList.add("chat", className);
  let contenido =
    className === "outgoing"
      ? `<p>${mensaje}</p>`
      : `<span class="material-symbols-outlined"><i class="fa-solid fa-robot"></i></span>
  <p>${mensaje}</p>`;
  chatLi.innerHTML = contenido;
  chatbox.appendChild(chatLi);
  chatbox.scrollTo(0, chatbox.scrollHeight);
  return chatLi;
};

//Función para simular respuestas flotantes
const generarRespuesta = () => {
  //Muestra la pregunta del bot
  const botResponse = addMessage(
    "¿Ya te registraste?<br>Por favor, elige una opción:",
    "incoming"
  );
  // Agregar botones como opciones flotantes
  const button1 = addButton("Registrarme");
  const button2 = addButton("Comprar");

  // Agregar eventos de clic a los botones
  button1.addEventListener("click", () => handleOptionClick("Registrarme"));
  button2.addEventListener("click", () => handleOptionClick("Comprar"));
};

//FUNCIÓN PARA CREAR BOTONES
const addButton = (text) => {
  const button = document.createElement("button");
  button.textContent = text;
  button.classList.add("option-button", "incoming");
  chatbox.appendChild(button);
  return button;
};

//FUNCIÓN PARA MOSTRAR EL FORMULARIO
const showRegisterForm = () => {
  // Oculta el cuadro de entrada de chat temporalmente
  chatInput.style.display = "none";

  // Muestra el formulario de registro
  const registrationForm = document.createElement("div");
  registrationForm.innerHTML = `
  <div class="container-fluid border border-black">
    <h3>Regístrate</h3>
    <form method="POST">
    <labe class="form-label" for="username">Nombre de usuario:</label>
    <input class="form-control" type="text" id="username" name="username"  autocomplete="username" required>
    <label class="form-label" for="password">Contraseña:</label>
    <input class="form-control" type="password" id="password" name="password" autocomplete="current-password" required>
    <button class="btn btn-primary mt-2" id="submit-registration" type="Submit">Ingresar</button>
    </form>
  </div>
  `;
  chatbox.appendChild(registrationForm);

  // Agrega un evento al botón de registro
  const submitButton = document.getElementById("submit-registration");
  submitButton.addEventListener("click", handleRegistrationSubmit);
};

//FUNCIÓN PARA ENVIAR LOS DATOS
const handleRegistrationSubmit = () => {
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  const userData = {
    username: username,
    password: password,
  };
  // Realiza la solicitud POST al servidor
  fetch("Models/IniciarSesion.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error al registrar usuario");
      }
      return response.json();
    })
    .then((data) => {
      // Manejar la respuesta del servidor, si es necesario
      console.log("Usuario registrado exitosamente:", data);
      // Muestra un mensaje en el chat
      addMessage(`Usuario registrado: ${username}`, "incoming");
      // Limpia el formulario y vuelve a mostrar el cuadro de entrada de chat
      clearRegistrationForm();
      chatInput.style.display = "block";
    })
    .catch((error) => {
      console.error("Error:", error);
      // Puedes manejar el error como desees, por ejemplo, mostrar un mensaje de error en el chat
      addMessage("Error al registrar usuario", "incoming");
    });

  // Simplemente muestra un mensaje por ahora
  addMessage(`Usuario registrado: ${username}`, "incoming");

  // Limpia el formulario y vuelve a mostrar el cuadro de entrada de chat
  clearRegistrationForm();
  chatInput.style.display = "block";
};

const clearRegistrationForm = () => {
  const registrationForm = document.querySelector(".chatbox > div");
  if (registrationForm) {
    chatbox.removeChild(registrationForm);
  }
};
//FUNCIÓN PARA SELECCIONAR ALGUNOS DE LAS PREGUNTAS FLOTANTES
const handleOptionClick = (option) => {
  addMessage(`${option}`, "outgoing");
  if (option === "Registrarme") {
    showRegisterForm();
  } else if (option === "Comprar") {
  }
};

const handleUserChat = () => {
  mensaje = chatInput.value.trim();
  if (!mensaje || chatInput.style.display === "none") return;
  //Para eliminar el mensaje del input despues de haberlo enviado
  chatInput.value = "";
  chatInput.style.height = `${inputInitHeight}px`;
  // Agregar mensaje de usuario
  const userMessage = addMessage(mensaje, "outgoing");

  //Primero se mostrara escribiendo
  setTimeout(() => {
    const writingMessage = addMessage("Escribiendo.....", "incoming");
    //y despues mostrara el mensaje
    setTimeout(() => {
      chatbox.removeChild(writingMessage);
      generarRespuesta();
    }, 600);
  }, 600);
};

chatInput.addEventListener("input", () => {
  chatInput.style.height = `${inputInitHeight}px`;
  chatInput.style.height = `${chatInput.scrollHeight}px`;
});

//Función para enviar mensajes al presionar Enter
chatInput.addEventListener("keydown", (e) => {
  if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
    e.preventDefault();
    handleUserChat();
  }
});

//Evento para cerrar el chat en computadora
chatbotToggler.addEventListener("click", () =>
  document.body.classList.toggle("show-chatbot")
);
//Evento para cerrar el chat en telefonos
chatbotClose.addEventListener("click", () =>
  document.body.classList.remove("show-chatbot")
);
addMessage(
  "¡Hola! Soy un asistente virtual. ¿En qué puedo ayudarte?",
  "incoming"
);
enviar.addEventListener("click", handleUserChat);
