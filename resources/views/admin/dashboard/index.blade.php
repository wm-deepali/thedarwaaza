@include('admin.top-header')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  :root {
    --bg: #f1f2f4;
    --surface: #ffffff;
    --border: #e3e5e8;
    --text-primary: #202223;
    --text-secondary: #6d7175;
    --text-hint: #8c9196;
    --accent: #303d89;
    --accent-light: #f0f1fc;
    --green: #007a5e;
    --green-bg: #e3f1ec;
    --amber: #916a00;
    --amber-bg: #fff5cc;
    --blue: #0069d9;
    --blue-bg: #e8f2ff;
    --red: #b22222;
    --red-bg: #fce8e8;
    --radius-sm: 8px;
    --radius-md: 12px;
    --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
    --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  }

  .content-area * { box-sizing: border-box; }

  .content-area {
    background: var(--bg);
    padding: 24px 28px;
    min-height: 100vh;
    font-family: var(--font);
    color: var(--text-primary);
  }

  .dash-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  .dash-page-header h1 {
    font-size: 20px;
    font-weight: 650;
    color: var(--text-primary) !important;
    margin: 0;
  }
  .dash-page-header .dash-meta {
    font-size: 13px;
    color: var(--text-secondary);
    margin-top: 2px;
  }
  .dash-date-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 7px 13px;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary);
    box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
  }

  .cardx {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 20px;
    box-shadow: var(--shadow-card);
    height: 100%;
    transition: box-shadow .18s;
  }
  .cardx:hover { box-shadow: 0 3px 10px rgba(0, 0, 0, .1), 0 0 0 1px var(--border); }
  .cardx h1, .cardx h2, .cardx h3, .cardx h4, .cardx h6,
  .cardx p, .cardx td, .cardx th, .cardx li { color: var(--text-primary) !important; }
  .cardx h5 {
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .02em;
    text-transform: uppercase;
    color: var(--text-secondary) !important;
    margin-bottom: 16px;
  }

  .kpi-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 20px 20px 18px;
    box-shadow: var(--shadow-card);
    position: relative;
    height: 100%;
    transition: box-shadow .18s;
  }
  .kpi-card:hover { box-shadow: 0 3px 10px rgba(0, 0, 0, .1), 0 0 0 1px var(--border); }
  .kpi-label { font-size: 13px; font-weight: 500; color: var(--text-secondary); margin-bottom: 6px; }
  .kpi-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-primary) !important;
    line-height: 1.1;
    margin-bottom: 10px;
  }
  .kpi-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 20px;
  }
  .kpi-badge.up   { background: var(--green-bg); color: var(--green); }
  .kpi-badge.down { background: var(--red-bg);   color: var(--red); }
  .kpi-badge.warn { background: var(--amber-bg); color: var(--amber); }
  .kpi-badge.info { background: var(--blue-bg);  color: var(--blue); }
  .kpi-icon {
    position: absolute;
    top: 18px;
    right: 18px;
    width: 36px;
    height: 36px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    opacity: .85;
  }
  .kpi-icon.purple { background: #ede9fe; color: #6d28d9; }
  .kpi-icon.green  { background: var(--green-bg); color: var(--green); }
  .kpi-icon.blue   { background: var(--blue-bg); color: var(--blue); }
  .kpi-icon.amber  { background: var(--amber-bg); color: var(--amber); }
  .kpi-sub { font-size: 12px; color: var(--text-hint); }

  .progress { height: 6px; border-radius: 10px; background: var(--bg); overflow: hidden; }
  .progress-bar { border-radius: 10px; }
  .progress-row { margin-bottom: 14px; }
  .progress-row:last-child { margin-bottom: 0; }
  .progress-label { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 5px; }
  .progress-label span:first-child { color: var(--text-secondary); font-weight: 500; }
  .progress-label span:last-child { color: var(--text-primary); font-weight: 600; }

  .dash-table { width: 100%; border-collapse: collapse; font-size: 13px; }
  .dash-table thead th {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--text-hint) !important;
    padding: 0 12px 10px;
    border-bottom: 1px solid var(--border);
    text-align: left;
  }
  .dash-table tbody tr { border-bottom: 1px solid var(--bg); transition: background .12s; }
  .dash-table tbody tr:hover { background: var(--bg); }
  .dash-table tbody tr:last-child { border-bottom: none; }
  .dash-table tbody td { padding: 11px 12px; color: var(--text-primary) !important; vertical-align: middle; }

  .status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
  }
  .status-pill::before { content: ''; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
  .status-pill.active   { background: var(--green-bg); color: var(--green); }
  .status-pill.active::before   { background: var(--green); }
  .status-pill.inactive { background: var(--red-bg); color: var(--red); }
  .status-pill.inactive::before { background: var(--red); }

  .product-rank-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--bg);
    font-size: 13px;
  }
  .product-rank-item:last-child { border-bottom: none; }
  .product-rank-item .rank {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--bg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: var(--text-secondary);
    flex-shrink: 0;
    margin-right: 10px;
  }
  .product-rank-item .name { flex: 1; font-weight: 500; color: var(--text-primary); }
  .product-rank-item .qty {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-primary);
    background: var(--bg);
    padding: 2px 8px;
    border-radius: 6px;
  }

  .quick-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 12px;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary) !important;
    text-decoration: none;
    margin-bottom: 8px;
    transition: all .15s;
  }
  .quick-link:last-child { margin-bottom: 0; }
  .quick-link i { color: var(--accent); width: 16px; text-align: center; }
  .quick-link:hover { background: var(--accent-light); border-color: var(--accent); }

  .view-all { font-size: 12px; font-weight: 600; color: var(--accent); text-decoration: none; }
  .view-all:hover { text-decoration: underline; }

  .chart-wrap { position: relative; height: 240px; }
  .empty-note { font-size: 13px; color: var(--text-hint); padding: 12px 0; }

  @media (max-width: 768px) {
    .content-area { padding: 16px; }
    .kpi-value { font-size: 24px; }
  }
</style>

<div class="main-section">
  @include('admin.header')

  <div class="container-fluid">
    <div class="content-area">

      <!-- Page header -->
      <div class="dash-page-header">
        <div>
          <h1>Overview</h1>
          <div class="dash-meta">Welcome back, {{ auth()->user()->name }}</div>
        </div>
        <div class="dash-date-badge">
          <i class="fa fa-calendar-alt" style="color:var(--text-hint)"></i>
          {{ now()->format('jS M, Y') }}
        </div>
      </div>

      <!-- KPI row -->
      <div class="row g-3 mb-3">

        <div class="col-xl-3 col-md-6">
          <div class="kpi-card">
            <div class="kpi-icon purple"><i class="fa-solid fa-envelope"></i></div>
            <div class="kpi-label">Total Enquiries</div>
            <div class="kpi-value">{{ number_format($enquiriesTotal) }}</div>
            <span class="kpi-badge info">{{ $enquiriesToday }} today</span>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="kpi-card">
            <div class="kpi-icon green"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="kpi-label">Enquiries This Month</div>
            <div class="kpi-value">{{ number_format($enquiriesThis) }}</div>
            <span class="kpi-badge {{ $enquiryChange >= 0 ? 'up' : 'down' }}">
              <i class="fa fa-arrow-{{ $enquiryChange >= 0 ? 'up' : 'down' }}"></i>
              {{ abs($enquiryChange) }}%
            </span>
            <span class="kpi-sub">vs last month ({{ $enquiriesLast }})</span>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="kpi-card">
            <div class="kpi-icon blue"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div class="kpi-label">Total Products</div>
            <div class="kpi-value">{{ number_format($productsTotal) }}</div>
            <span class="kpi-badge up">{{ $productsActive }} active</span>
            <span class="kpi-sub">{{ $productsThis }} added this month</span>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="kpi-card">
            <div class="kpi-icon amber"><i class="fa-solid fa-layer-group"></i></div>
            <div class="kpi-label">Categories</div>
            <div class="kpi-value">{{ number_format($categoriesTotal) }}</div>
            <span class="kpi-badge warn">{{ $subCategories }} sub categories</span>
          </div>
        </div>

      </div>

      <!-- Chart + Quick links -->
      <div class="row g-3 mb-3">

        <div class="col-lg-8">
          <div class="cardx">
            <h5>Enquiries – Last 6 Months</h5>
            <div class="chart-wrap">
              <canvas id="enquiryChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="cardx">
            <h5>Quick Links</h5>
            <a class="quick-link" href="{{ route('admin.products.index') }}">
              <i class="fa-solid fa-boxes-stacked"></i> Manage Products
            </a>
            <a class="quick-link" href="{{ route('admin.categories.index') }}">
              <i class="fa-solid fa-layer-group"></i> Categories & Sub Categories
            </a>
            <a class="quick-link" href="{{ route('admin.contact-enquiries.index') }}">
              <i class="fa-solid fa-envelope"></i> Enquiries
            </a>
            <a class="quick-link" href="{{ route('admin.home-blocks.index') }}">
              <i class="fa-solid fa-house"></i> Home Page
              <span class="kpi-sub" style="margin-left:auto">{{ $homeBlocks }} blocks</span>
            </a>
            <a class="quick-link" href="{{ route('admin.about-page.edit') }}">
              <i class="fa-solid fa-circle-info"></i> About Page
            </a>
            <a class="quick-link" href="{{ route('admin.contact-locations.index') }}">
              <i class="fa-solid fa-location-dot"></i> Contact Addresses
              <span class="kpi-sub" style="margin-left:auto">{{ $contactLocations }}</span>
            </a>
            <a class="quick-link" href="{{ route('admin.seo.index') }}">
              <i class="fa-solid fa-bullhorn"></i> SEO Management
            </a>
          </div>
        </div>

      </div>

      <!-- Latest enquiries + Products by category -->
      <div class="row g-3 mb-3">

        <div class="col-lg-8">
          <div class="cardx">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0">Latest Enquiries</h5>
              <a class="view-all" href="{{ route('admin.contact-enquiries.index') }}">View all</a>
            </div>

            @if($latestEnquiries->count())
              <div class="table-responsive">
                <table class="dash-table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($latestEnquiries as $enquiry)
                      <tr>
                        <td>{{ $enquiry->name ?? '-' }}</td>
                        <td>{{ $enquiry->email ?? '-' }}</td>
                        <td>{{ $enquiry->phone ?? $enquiry->mobile ?? '-' }}</td>
                        <td>{{ $enquiry->created_at?->format('d M Y') }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="empty-note">No enquiries yet.</div>
            @endif
          </div>
        </div>

        <div class="col-lg-4">
          <div class="cardx">
            <h5>Products by Category</h5>
            @forelse($categoryStats as $cat)
              <div class="progress-row">
                <div class="progress-label">
                  <span>{{ $cat->name }}</span>
                  <span>{{ $cat->products_count }}</span>
                </div>
                <div class="progress">
                  <div class="progress-bar"
                       style="width: {{ round(($cat->products_count / $maxCategoryProducts) * 100) }}%; background: var(--accent);"></div>
                </div>
              </div>
            @empty
              <div class="empty-note">No categories yet.</div>
            @endforelse
          </div>
        </div>

      </div>

      <!-- Recently added products -->
      <div class="row g-3">
        <div class="col-12">
          <div class="cardx">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0">Recently Added Products</h5>
              <a class="view-all" href="{{ route('admin.products.index') }}">View all</a>
            </div>

            @forelse($recentProducts as $i => $product)
              <div class="product-rank-item">
                <div class="rank">{{ $i + 1 }}</div>
                <div class="name">{{ $product->name }}</div>
                @if(isset($product->status))
                  <span class="status-pill {{ $product->status ? 'active' : 'inactive' }}" style="margin-right:10px">
                    {{ $product->status ? 'Active' : 'Inactive' }}
                  </span>
                @endif
                <div class="qty">{{ $product->created_at?->format('d M') }}</div>
              </div>
            @empty
              <div class="empty-note">No products added yet.</div>
            @endforelse
          </div>
        </div>
      </div>

    </div><!-- /content-area -->
  </div><!-- /container-fluid -->
</div><!-- /main-section -->

@include('admin.footer')

<script>
  new Chart(document.getElementById('enquiryChart'), {
    type: 'bar',
    data: {
      labels: @json($chartLabels),
      datasets: [{
        label: 'Enquiries',
        data: @json($chartData),
        backgroundColor: '#303d89',
        borderRadius: 6,
        maxBarThickness: 42
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f1f2f4' } },
        x: { grid: { display: false } }
      }
    }
  });
</script>