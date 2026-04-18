<?php
/**
 * ARQUIVO: inc/rodape.php
 * FUNÇÃO: Fechar estrutura HTML aberta no cabecalho.php
 * 
 * EQUIVALENTE JAVA: footer.jsp ou fechamento do layout.html
 */
?>
        </div><!-- Fecha .conteudo -->
    </div><!-- Fecha .container -->
    
    <!-- JAVASCRIPT (Vanilla) -->
    <script>
        /**
         * Funções JavaScript globais para interatividade
         */
        
        // Confirmação antes de excluir (usada nos botões "Excluir")
        function confirmarExclusao(event) {
            if (!confirm('⚠️ Tem certeza que deseja excluir este item?\nEsta ação não pode ser desfeita!')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
        
        // Confirmação genérica
        function confirmarAcao(mensagem, event) {
            if (!confirm(mensagem || 'Tem certeza?')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
        
        // Auto-hide para mensagens de alerta (some após 5 segundos)
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
        
        // Formatação de campos monetários (inputs com data-type="currency")
        document.addEventListener('DOMContentLoaded', function() {
            const currencyInputs = document.querySelectorAll('input[data-type="currency"]');
            currencyInputs.forEach(function(input) {
                input.addEventListener('blur', function(e) {
                    let value = this.value.replace(/\D/g, '');
                    value = (parseFloat(value) / 100).toFixed(2);
                    this.value = value.replace('.', ',');
                });
                
                input.addEventListener('focus', function(e) {
                    this.value = this.value.replace(/\D/g, '');
                });
            });
        });
        
        // Máscara simples para telefone (opcional)
        function mascaraTelefone(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 10) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            } else if (value.length > 5) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            }
            input.value = value;
        }
    </script>
</body>
</html>