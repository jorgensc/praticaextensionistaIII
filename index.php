<?php
$pageTitle = "Início";
include 'header.php';
?>

<header class="masthead text-white text-center" style="background-image: url('assets/img/banner-coloratto.jpg'); background-size: cover; background-position: center;">
    <div class="container d-flex align-items-center flex-column" style="padding: 8rem 0;">
        <h1 class="masthead-heading mb-0">Seu Espaço, Sua Cor</h1>
        <h1 class="masthead-subheading mb-3">Transformando Ambientes</h1>
        <p class="mb-4 px-5">Na Coloratto Tintas, acreditamos que a cor tem o poder de transformar qualquer ambiente. Seja para sua casa, escritório ou fachada, nossa equipe de pintores profissionais está pronta para trazer vida nova ao seu espaço com qualidade e paixão.</p>
        <a href="<?php echo BASE_URL; ?>orçamentos.php" class="btn btn-primary btn-lg">Solicite um Orçamento</a>
    </div>
</header>

<section class="page-section clearfix">
    <div class="container">
        <div class="intro">
            <div class="intro-text left-0 text-center bg-faded p-5 rounded">
                <h2 class="section-heading mb-4">
                    <span class="section-heading-upper">Qualidade que Você Vê</span>
                    <span class="section-heading-lower">Nossos Diferenciais</span>
                </h2>
                <p class="mb-3">Combinamos anos de experiência com as melhores técnicas e materiais do mercado para garantir um acabamento impecável. Nosso compromisso é com a sua satisfação, do planejamento à execução, com atenção a cada detalhe.</p>
                <div class="intro-button mx-auto">
                    <a class="btn btn-primary btn-xl" href="<?php echo BASE_URL; ?>serviços.php">Conheça Nossos Serviços!</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="page-section cta">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 mx-auto">
                <div class="cta-inner bg-faded text-center rounded">
                    <h2 class="section-heading mb-4">
                        <span class="section-heading-upper">Por que Coloratto?</span>
                        <span class="section-heading-lower">Confiabilidade e Experiência</span>
                    </h2>
                    <p class="mb-0">Somos especialistas em transformar ideias em realidade, valorizando seu patrimônio com cores e acabamentos que duram. Conte com a Coloratto para um serviço eficiente, limpo e que supera suas expectativas.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
