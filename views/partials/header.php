<header class="site-header">
    <a class="brand" href="/">
        <span class="brand-logo">ABC</span>
    </a>

    <nav aria-label="Main Navigation">
        <a class="<?= $page === 'home' ? 'active' : '' ?>" href="/">Home</a>
        <a class="<?= $page === 'manage' ? 'active' : '' ?>" href="/manage">Manage</a>
        <a class="<?= $page === 'about' ? 'active' : '' ?>" href="/about">About</a>
    </nav>

    <span class="header-note">Exam</span>
</header>