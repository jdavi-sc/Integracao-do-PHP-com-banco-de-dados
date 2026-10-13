<?php
require_once __DIR__ . '/../config/Conexao.php';
require_once __DIR__ . '/../models/cliente_model.php';

$clientes = buscarClientes($pdo);

function getIniciais($nome) {
    $partes = array_values(array_filter(explode(' ', trim($nome))));
    if (empty($partes)) return 'CL';
    $iniciais = mb_strtoupper(mb_substr($partes[0], 0, 1));
    if (count($partes) > 1) {
        $iniciais .= mb_strtoupper(mb_substr(end($partes), 0, 1));
    }
    return $iniciais;
}

function formatarCpf($cpf) {
    $limpo = preg_replace('/\D/', '', (string)$cpf);
    if (strlen($limpo) === 11) {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $limpo);
    }
    return htmlspecialchars((string)$cpf);
}

function formatarData($data) {
    if (!$data) return '-';
    $timestamp = strtotime($data);
    return $timestamp ? date('d/m/Y', $timestamp) : htmlspecialchars($data);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes | Gestão de Clientes</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --brand-primary: #2563eb;
            --brand-primary-hover: #1d4ed8;
            --brand-primary-light: #eff6ff;
            --brand-accent: #10b981;
            --brand-dark: #0f172a;
            --brand-slate: #1e293b;
            --brand-muted: #64748b;
            --brand-border: #e2e8f0;
            --brand-bg: #f8fafc;
            --brand-card-bg: #ffffff;
            --font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--brand-bg);
            color: var(--brand-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .app-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--brand-border);
        }

        .brand-badge {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
            flex-shrink: 0;
        }

        .nav-pill-link {
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            color: var(--brand-muted);
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .nav-pill-link:hover {
            color: var(--brand-primary);
            background-color: var(--brand-primary-light);
        }

        .nav-pill-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .app-card {
            background-color: var(--brand-card-bg);
            border: 1px solid var(--brand-border);
            border-radius: 1.25rem;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.02);
        }

        .card-top-accent {
            height: 5px;
            background: linear-gradient(90deg, #2563eb, #38bdf8, #10b981);
            border-top-left-radius: 1.25rem;
            border-top-right-radius: 1.25rem;
        }

        .search-control {
            border-radius: 0.75rem;
            border-color: var(--brand-border);
            font-size: 1rem;
            min-height: 48px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .search-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .btn {
            border-radius: 0.75rem;
            font-weight: 600;
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
            color: #ffffff;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-outline-secondary {
            border-color: var(--brand-border);
            color: var(--brand-slate);
            background-color: #ffffff;
        }

        .btn-outline-secondary:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            color: var(--brand-dark);
        }

        .client-mobile-card {
            background: #ffffff;
            border: 1px solid var(--brand-border);
            border-radius: 1rem;
            padding: 1.15rem;
            margin-bottom: 0.85rem;
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.03);
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
        }

        .client-mobile-card:active,
        .client-mobile-card:hover {
            border-color: #93c5fd;
            box-shadow: 0 6px 15px -3px rgba(37, 99, 235, 0.1);
        }

        .avatar-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: var(--brand-primary);
            font-weight: 700;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #bfdbfe;
            flex-shrink: 0;
        }

        .table-responsive {
            border-radius: 1.25rem;
        }

        .table th {
            font-size: 0.775rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--brand-muted);
            font-weight: 700;
            background-color: #f8fafc;
            padding: 1.1rem 1rem;
            border-bottom: 2px solid var(--brand-border);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            color: var(--brand-slate);
            border-bottom: 1px solid var(--brand-border);
        }

        .table tbody tr {
            transition: background-color 0.15s ease;
        }

        .table tbody tr:hover td {
            background-color: #f8fafc;
        }

        .id-badge {
            background-color: #f1f5f9;
            color: var(--brand-slate);
            font-weight: 700;
            font-size: 0.8rem;
            padding: 0.35rem 0.65rem;
            border-radius: 9999px;
            display: inline-block;
        }

        .cpf-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.9rem;
            letter-spacing: 0.02em;
        }

        footer {
            margin-top: auto;
            border-top: 1px solid var(--brand-border);
            background-color: #ffffff;
        }
    </style>
</head>

<body>

    <header class="app-navbar sticky-top py-2 py-md-3">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2">
            <a href="../index.html" class="d-flex align-items-center text-decoration-none text-dark gap-2">
                <div class="brand-badge">
                    <i class="bi bi-people-fill fs-5"></i>
                </div>
                <div>
                    <span class="fs-5 fw-bold tracking-tight text-dark d-block lh-1">Gestão de Clientes</span>
                    <small class="text-secondary" style="font-size: 0.75rem;">Integração PHP & PDO</small>
                </div>
            </a>

            <nav class="d-flex align-items-center gap-1 gap-sm-2" aria-label="Navegação Principal">
                <a href="../index.html" class="nav-pill-link">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Cadastrar</span>
                </a>
                <a href="./listar_clientes.php" class="nav-pill-link active" aria-current="page">
                    <i class="bi bi-list-ul"></i>
                    <span>Listar Clientes</span>
                </a>
            </nav>
        </div>
    </header>

    <main class="flex-grow-1 py-4 py-md-5">
        <div class="container">

            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
                <div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-semibold mb-2">
                        <i class="bi bi-database-check me-1"></i> Base de Clientes
                    </span>
                    <h1 class="h3 h2-md fw-bold text-dark mt-2 mb-1">Clientes Cadastrados</h1>
                    <p class="text-secondary small mb-0">Consulte, filtre e gerencie todos os registros na base de dados.</p>
                </div>

                <a href="../index.html" class="btn btn-primary btn-lg w-100 w-md-auto">
                    <i class="bi bi-person-plus-fill me-2"></i> Novo Cliente
                </a>
            </div>

            <div class="app-card shadow-sm p-3 p-md-4 mb-4">
                <div class="row g-2 align-items-center justify-content-between">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control search-control border-start-0 ps-0"
                                placeholder="Buscar por nome, CPF ou e-mail..." aria-label="Buscar clientes">
                            <button id="clearSearchBtn" class="btn btn-outline-secondary d-none px-3" type="button" aria-label="Limpar busca">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-md-auto d-flex align-items-center justify-content-between justify-content-md-end gap-2 pt-1 pt-md-0">
                        <span class="text-secondary small fw-medium">Total:</span>
                        <span id="counterBadge" class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fs-7 fw-semibold">
                            <?= count($clientes) ?> <?= count($clientes) === 1 ? 'cliente registrado' : 'clientes registrados' ?>
                        </span>
                    </div>
                </div>
            </div>

            <div id="noSearchResults" class="app-card shadow-sm p-4 text-center my-4 d-none">
                <i class="bi bi-search display-6 text-muted mb-2 d-block"></i>
                <h5 class="fw-bold text-dark mb-1">Nenhum resultado encontrado</h5>
                <p class="text-secondary small mb-0">Nenhum cliente corresponde ao termo pesquisado.</p>
            </div>

            <?php if (!empty($clientes)): ?>

                <div class="d-block d-md-none" id="mobileCardsContainer">
                    <?php foreach ($clientes as $cliente): ?>
                        <?php 
                            $nome = htmlspecialchars($cliente['nome_cliente'] ?? '');
                            $cpf = formatarCpf($cliente['cpf_cliente'] ?? '');
                            $email = htmlspecialchars($cliente['email_cliente'] ?? '');
                            $dataNasc = formatarData($cliente['data_nascimento_cliente'] ?? '');
                            $iniciais = getIniciais($cliente['nome_cliente'] ?? '');
                            $searchKey = mb_strtolower($nome . ' ' . preg_replace('/\D/', '', $cliente['cpf_cliente'] ?? '') . ' ' . $cpf . ' ' . $email);
                        ?>
                        <div class="client-mobile-card client-item" data-search="<?= $searchKey ?>">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-3 pb-2 border-bottom">
                                <div class="d-flex align-items-center gap-2 overflow-hidden">
                                    <div class="avatar-circle">
                                        <?= $iniciais ?>
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate"><?= $nome ?></h6>
                                        <span class="text-secondary" style="font-size: 0.75rem;">Cliente</span>
                                    </div>
                                </div>
                                <span class="id-badge">#<?= htmlspecialchars($cliente['id_cliente']) ?></span>
                            </div>

                            <div class="d-flex flex-column gap-2 small">
                                <div class="d-flex align-items-center text-secondary">
                                    <i class="bi bi-card-text text-primary me-2 fs-6"></i>
                                    <span class="fw-semibold text-dark me-1">CPF:</span>
                                    <span class="cpf-mono text-dark"><?= $cpf ?></span>
                                </div>

                                <div class="d-flex align-items-center text-secondary text-truncate">
                                    <i class="bi bi-envelope text-primary me-2 fs-6"></i>
                                    <span class="fw-semibold text-dark me-1">E-mail:</span>
                                    <a href="mailto:<?= $email ?>" class="text-decoration-none text-primary text-truncate"><?= $email ?></a>
                                </div>

                                <div class="d-flex align-items-center text-secondary">
                                    <i class="bi bi-calendar3 text-primary me-2 fs-6"></i>
                                    <span class="fw-semibold text-dark me-1">Nascimento:</span>
                                    <span class="text-dark"><?= $dataNasc ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-none d-md-block" id="desktopTableContainer">
                    <div class="app-card shadow-sm overflow-hidden">
                        <div class="card-top-accent"></div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="clientesTable">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;" class="ps-4">ID</th>
                                        <th>Cliente</th>
                                        <th>CPF</th>
                                        <th>E-mail</th>
                                        <th class="pe-4">Data de Nascimento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <?php 
                                            $nome = htmlspecialchars($cliente['nome_cliente'] ?? '');
                                            $cpf = formatarCpf($cliente['cpf_cliente'] ?? '');
                                            $email = htmlspecialchars($cliente['email_cliente'] ?? '');
                                            $dataNasc = formatarData($cliente['data_nascimento_cliente'] ?? '');
                                            $iniciais = getIniciais($cliente['nome_cliente'] ?? '');
                                            $searchKey = mb_strtolower($nome . ' ' . preg_replace('/\D/', '', $cliente['cpf_cliente'] ?? '') . ' ' . $cpf . ' ' . $email);
                                        ?>
                                        <tr class="client-item" data-search="<?= $searchKey ?>">
                                            <td class="ps-4">
                                                <span class="id-badge">#<?= htmlspecialchars($cliente['id_cliente']) ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar-circle">
                                                        <?= $iniciais ?>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-dark d-block"><?= $nome ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="cpf-mono text-dark fw-medium"><?= $cpf ?></span>
                                            </td>
                                            <td>
                                                <a href="mailto:<?= $email ?>" class="text-decoration-none text-primary d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope"></i>
                                                    <span><?= $email ?></span>
                                                </a>
                                            </td>
                                            <td class="pe-4">
                                                <span class="text-secondary d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-calendar-event text-primary"></i>
                                                    <span><?= $dataNasc ?></span>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <div class="app-card shadow-sm p-4 p-md-5 text-center my-4">
                    <div class="avatar-circle mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem;">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="h4 fw-bold text-dark mb-2">Nenhum cliente cadastrado</h3>
                    <p class="text-secondary small mb-4 mx-auto" style="max-width: 420px;">
                        Ainda não existem registros de clientes no banco de dados. Cadastre o primeiro cliente para começar.
                    </p>
                    <a href="../index.html" class="btn btn-primary btn-lg">
                        <i class="bi bi-person-plus-fill me-2"></i> Cadastrar Primeiro Cliente
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <footer class="py-3 text-center text-secondary small">
        <div class="container">
            <span>&copy; Gestão de Clientes &bull; Sistema Integrado PHP e Banco de Dados</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const clearSearchBtn = document.getElementById('clearSearchBtn');
            const counterBadge = document.getElementById('counterBadge');
            const noResultsCard = document.getElementById('noSearchResults');
            const clientItems = document.querySelectorAll('.client-item');
            const totalOriginal = <?= count($clientes) ?>;

            if (!searchInput) return;

            function filterClients() {
                const term = searchInput.value.trim().toLowerCase();

                if (term.length > 0) {
                    clearSearchBtn.classList.remove('d-none');
                } else {
                    clearSearchBtn.classList.add('d-none');
                }

                let matchesMobile = 0;
                let matchesDesktop = 0;

                clientItems.forEach(item => {
                    const searchData = item.getAttribute('data-search') || '';
                    const isMatch = searchData.includes(term);

                    if (isMatch) {
                        item.classList.remove('d-none');
                        if (item.classList.contains('client-mobile-card')) {
                            matchesMobile++;
                        } else {
                            matchesDesktop++;
                        }
                    } else {
                        item.classList.add('d-none');
                    }
                });

                const totalMatches = Math.max(matchesMobile, matchesDesktop);

                if (totalMatches === 0 && term.length > 0) {
                    noResultsCard.classList.remove('d-none');
                    counterBadge.textContent = '0 encontrados';
                    counterBadge.className = 'badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fs-7 fw-semibold';
                } else {
                    noResultsCard.classList.add('d-none');
                    if (term.length > 0) {
                        counterBadge.textContent = `${totalMatches} ${totalMatches === 1 ? 'encontrado' : 'encontrados'}`;
                        counterBadge.className = 'badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fs-7 fw-semibold';
                    } else {
                        counterBadge.textContent = `${totalOriginal} ${totalOriginal === 1 ? 'cliente registrado' : 'clientes registrados'}`;
                        counterBadge.className = 'badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fs-7 fw-semibold';
                    }
                }
            }

            searchInput.addEventListener('input', filterClients);

            clearSearchBtn.addEventListener('click', () => {
                searchInput.value = '';
                filterClients();
                searchInput.focus();
            });
        });
    </script>
</body>

</html>