<?php
class Page {
    private string $name;
    private string $template;

    public function __construct(string $name, string $template) {
        $this->name = $name;
        $this->template = $template;
    }

    protected function setTemplate(string $template): void {
        $this->template = $template;
    }

    public function render(): void {
        echo $this->template;
    }
}

class BlogPage extends Page {
    public function __construct() {
        parent::__construct('blog', '');
        $type = $_GET['type'] ?? 'slimes';
        $this->setType($type);
    }

    public function setType(string $type): void {
        if ($type === 'plorts') {
            $this->generatePlortsTemplate();
        } else {
            $this->generateSlimesTemplate();
        }
    }

    private function generateSlimesTemplate(): void {
        $slimes = [
            ['name' => 'Розовый слайм',     'img' => 'image/slime1.png'],
            ['name' => 'Фосфорный слайм',   'img' => 'image/slime2.png'],
            ['name' => 'Кристальный слайм', 'img' => 'image/slime3.jpg']
        ];
        $html = $this->buildCardsHtml($slimes);
        $this->setTemplate($html);
    }

    private function generatePlortsTemplate(): void {
        $plorts = [
            ['name' => 'Розовый плорт',     'img' => 'image/plort1.png'],
            ['name' => 'Фосфорный плорт',   'img' => 'image/plort2.png'],
            ['name' => 'Кристальный плорт', 'img' => 'image/plort3.png']
        ];
        $html = $this->buildCardsHtml($plorts);
        $this->setTemplate($html);
    }

    private function buildCardsHtml(array $items): string {
        $html = '<div class="cards-container">';
        foreach ($items as $item) {
            $html .= '<div class="card">';
            $html .= '<img src="' . htmlspecialchars($item['img']) . '" alt="' . htmlspecialchars($item['name']) . '">';
            $html .= '<p>' . htmlspecialchars($item['name']) . '</p>';
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}

$pageParam = $_GET['page'] ?? 'page';

if ($pageParam === 'blog') {
    $page = new BlogPage();
    if (isset($_GET['type'])) {
        $page->setType($_GET['type']);
    }
} else {
    $mainTemplate = '
    <div class="main-menu">
        <h1>Слаймопедия Slime Rancher 2</h1>
        <div class="buttons">
            <a href="?page=blog&type=slimes" class="btn">Слаймы</a>
            <a href="?page=blog&type=plorts" class="btn">Плорты</a>
        </div>
        <p>Выберите раздел, чтобы узнать больше!</p>
    </div>';
    $page = new Page('page', $mainTemplate);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Slime Rancher 2 – Слаймопедия</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            position: relative;
            color: #2d3e2b;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('image/fon.jpg') no-repeat center center fixed;
            background-size: cover;
            opacity: 0.7;
            z-index: -2;
        }
        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 248, 225, 0.75);
            z-index: -1;
        }
        .nav-links {
            background: rgba(192, 214, 179, 0.9);
            padding: 12px 20px;
            border-radius: 30px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            backdrop-filter: blur(2px);
        }
        .nav-links a {
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            color: #2c5e2a;
            background: #f9f3d9;
            padding: 6px 18px;
            border-radius: 25px;
            transition: 0.2s;
        }
        .nav-links a:hover {
            background: #ffefb5;
            transform: scale(1.02);
        }
        .main-menu {
            text-align: center;
            background: rgba(255, 250, 240, 0.9);
            padding: 90px;
            border-radius: 40px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
            margin-top: 8vw;
            backdrop-filter: blur(3px);
        }
        .buttons {
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            background: #ffb347;
            color: white;
            font-size: 1.3rem;
            font-weight: bold;
            padding: 12px 30px;
            margin: 0 15px;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.2s;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn:hover {
            background: #ff9f1c;
            transform: translateY(-2px);
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            margin-top: 8vw;
        }
        .card {
            background: rgba(255, 249, 239, 0.95);
            border-radius: 30px;
            padding: 15px;
            width: 200px;
            text-align: center;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            backdrop-filter: blur(2px);
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ffd966;
        }
        .card p {
            font-weight: bold;
            margin: 12px 0 0;
            font-size: 1.1rem;
            color: #4a6e3b;
        }
        .switch-type {
            text-align: center;
            margin: 20px;
            
        }
        .switch-type a {
            display: inline-block;
            background: #7cb342;
            color: white;
            padding: 8px 20px;
            margin: 0 10px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
        }
        .switch-type a:hover {
            background: #558b2f;
        }
        footer {
            text-align: center;
            margin-top: 40px;
            color: #2d4a1e;
            font-weight: bold;
            background: rgba(255,250,210,0.7);
            padding: 10px;
            border-radius: 30px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            backdrop-filter: blur(2px);
        }
    </style>
</head>
<body>

<div class="nav-links">
    <a href="?page=page">Главная</a>
</div>

<?php
$page->render();

if ($pageParam === 'blog') : ?>
    <div class="switch-type">
        <a href="?page=page">Назад</a>
    </div>
<?php endif; ?>

<footer>
    Slime Rancher 2 — путешествие в мир слаймов и плортов
</footer>

</body>
</html>
