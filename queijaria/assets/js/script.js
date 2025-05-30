document.addEventListener('DOMContentLoaded', function() {
    // Máscara de telefone (DDD) X XXXX-XXXX
    const telefoneInput = document.getElementById('telefone');
    
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            let formattedValue = '';
            
            if (value.length > 0) {
                formattedValue = '(' + value.substring(0, 2);
            }
            if (value.length > 2) {
                formattedValue += ') ' + value.substring(2, 3);
            }
            if (value.length > 3) {
                formattedValue += ' ' + value.substring(3, 7);
            }
            if (value.length > 7) {
                formattedValue += '-' + value.substring(7, 11);
            }
            
            this.value = formattedValue;
        });

        telefoneInput.addEventListener('keydown', function(e) {
            if ([8, 9, 37, 38, 39, 40, 46, 36, 35].includes(e.keyCode)) {
                return;
            }
            
            if (e.key < '0' || e.key > '9') {
                e.preventDefault();
            }
            
            if (this.value.replace(/\D/g, '').length >= 11 && ![8, 46].includes(e.keyCode)) {
                e.preventDefault();
            }
        });
    }

    // Indicador de força da senha
    const senhaInput = document.getElementById('senha');
    
    if (senhaInput) {
        senhaInput.addEventListener('input', function() {
            const password = this.value;
            const strengthContainer = this.nextElementSibling;
            const strengthBars = strengthContainer.querySelectorAll('.strength-bar');
            const strengthText = strengthContainer.querySelector('.strength-text');
            
            // Reset
            strengthContainer.className = 'password-strength';
            strengthText.textContent = '';
            
            // Calcula força baseada apenas no comprimento
            if (password.length > 0) {
                if (password.length < 6) {
                    // Não atinge o mínimo
                    strengthText.textContent = 'Mínimo 6 caracteres';
                } else if (password.length <= 10) {
                    strengthContainer.classList.add('password-weak');
                    strengthText.textContent = 'Fraca';
                } else if (password.length <= 15) {
                    strengthContainer.classList.add('password-medium');
                    strengthText.textContent = 'Média';
                } else {
                    strengthContainer.classList.add('password-strong');
                    strengthText.textContent = 'Forte';
                }
            }
        });
    }
});