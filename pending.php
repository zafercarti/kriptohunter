<?php
// pending.php
require_once 'config.php';
require_once 'includes/functions.php';

$symbol = isset($_GET['symbol']) ? $_GET['symbol'] : '';

$page_title = "Sembol Beklemede - KriptoHunter";

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card-dark p-5">
                <i class="fas fa-clock fa-4x text-warning mb-4"></i>
                <h2>Sembol Beklemede: <?php echo htmlspecialchars($symbol); ?></h2>
                <p class="lead mt-3">Bu sembol şu anda sistemimizde bulunmamaktadır.</p>
                
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle"></i>
                    <strong>Bilgi:</strong> Sembol talebiniz kaydedildi. En kısa sürede incelenecek ve eklenecektir.
                </div>
                
                <div class="mt-4">
                    <h5>Alternatif Semboller</h5>
                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                        <?php
                        $popular = mysqli_query($conn, "SELECT symbol FROM assets WHERE type = 'stock' ORDER BY search_count DESC LIMIT 12");
                        while($row = mysqli_fetch_assoc($popular)):
                        ?>
                        <a href="/search.php?q=<?php echo $row['symbol']; ?>" class="btn btn-sm btn-outline-primary">
                            <?php echo $row['symbol']; ?>
                        </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                
                <div class="mt-5">
                    <a href="/" class="btn btn-primary">
                        <i class="fas fa-home"></i> Ana Sayfaya Dön
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>