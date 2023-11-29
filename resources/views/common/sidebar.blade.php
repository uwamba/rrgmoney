<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-university"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RRG MOENY</div>
    </a>



    <!-- Nav Item - Pages Collapse Menu -->
    @hasrole(['Admin','Agent'])
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fas fa-user-alt"></i>
            <span>User Management</span>
        </a>
        <div id="taTpDropDown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management:</h6>
                <a class="collapse-item" href="{{ route('users.index') }}">List</a>
                <a class="collapse-item" href="{{ route('users.create') }}">Add New</a>
                <a class="collapse-item" href="{{ route('users.import') }}">Import Data</a>
            </div>
        </div>
    </li>
     @endhasrole
       @hasrole('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown_cashout"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
            <span>Account Cashout</span>
        </a>
        <div id="taTpDropDown_cashout" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Account Cashout:</h6>
                <a class="collapse-item" href="{{ route('cashout.admin_index') }}">List</a>
            </div>
        </div>

    </li>


    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages_country"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Countries</span>
        </a>
        <div id="collapsePages_country" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Countries</h6>
                <a class="collapse-item" href="{{ route('country.index') }}">Country List</a>
                <a class="collapse-item" href="{{ route('country.create') }}">Add new Country</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown_account"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
            <span>Accounts</span>
        </a>
        <div id="taTpDropDown_account" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Cash Accounts:</h6>
                <a class="collapse-item" href="{{ route('account.index') }}">List</a>
                <a class="collapse-item" href="{{ route('account.create') }}">New Account</a>
            </div>
        </div>

    </li>
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages_currency"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Currency</span>
        </a>
        <div id="collapsePages_currency" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Currency</h6>
                <a class="collapse-item" href="{{ route('currency.index') }}">List</a>
                <a class="collapse-item" href="{{ route('currency.create') }}">add new Curreny</a>
            </div>
        </div>
    </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages_role"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Role/permisions</span>
            </a>
            <div id="collapsePages_role" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Role & Permissions</h6>
                    <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
                    <a class="collapse-item" href="{{ route('permissions.index') }}">Permissions</a>
                </div>
            </div>
        </li>
    @endhasrole
    @hasrole('Customer')
    <!-- Heading -->
    <div class="sidebar-heading">
        Customer Section
    </div>
    <!-- Nav Item - Create Account Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown2"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
            <span>Account Topup</span>
        </a>
        <div id="taTpDropDown2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Account Topup:</h6>
                <a class="collapse-item" href="{{ route('topup.index') }}">List</a>
                <a class="collapse-item" href="{{ route('topup.create') }}">Add New</a>
            </div>
        </div>

    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages_cashout"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Cashout</span>
        </a>
        <div id="collapsePages_cashout" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Cashout</h6>
                <a class="collapse-item" href="{{ route('cashout.index') }}">List</a>
                <a class="collapse-item" href="{{ route('cashout.create') }}">add new Request</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown3"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fa fa-space-shuttle" aria-hidden="true"></i>
            <span>Send/Received</span>
        </a>
        <div id="taTpDropDown3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('send.received') }}">Received</a>
                <a class="collapse-item" href="{{ route('send.index') }}">Sent</a>
                <a class="collapse-item" href="{{ route('send.create') }}">New Transfer</a>
            </div>
        </div>

    </li>




    <!-- Divider -->
    <hr class="sidebar-divider">
    @endhasrole
    @hasrole(['Admin','Agent'])

    <!-- Nav Item - Create Account Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown2"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
            <span>Account Topup</span>
        </a>
        <div id="taTpDropDown2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Account Topup:</h6>
                <a class="collapse-item" href="{{ route('topup.admin_index') }}">List</a>
            </div>
        </div>

    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown3"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fa fa-space-shuttle" aria-hidden="true"></i>
            <span>Transfer</span>
        </a>
        <div id="taTpDropDown3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('send.agent_transfer') }}">Transfers</a>

            </div>
        </div>
      </li>
      <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown10"
                  aria-expanded="true" aria-controls="taTpDropDown">
                  <i class="fa fa-space-shuttle" aria-hidden="true"></i>
                  <span>Top Up</span>
              </a>
              <div id="taTpDropDown10" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="{{ route('topup.admin_index') }}">Top Up list</a>
                      <a class="collapse-item" href="{{ route('topup.agentTopUp') }}">New Top Up</a>
                  </div>
              </div>
            </li>
     <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown_payment"
                aria-expanded="true" aria-controls="taTpDropDown">
                <i class="fa fa-plus-square" aria-hidden="true"></i>
                <span>Payment</span>
            </a>
            <div id="taTpDropDown_payment" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

                    <a class="collapse-item" href="{{ route('safe_pay.admin_index') }}">Onhold Payment</a>
                    <a class="collapse-item" href="{{ route('safe_pay.admin_history') }}">History Payment</a>
                </div>
            </div>

        </li>

    @endhasrole
    @hasrole('Agent')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown_stock"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
            <span>Stock</span>
        </a>
        <div id="taTpDropDown_stock" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Stock:</h6>

                <a class="collapse-item" href="{{ route('stock.index') }}">List</a>
                <a class="collapse-item" href="{{ route('stock.create') }}">New Request</a>
            </div>
        </div>


    </li>
    @endhasrole
    @hasrole('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#taTpDropDown_stock"
            aria-expanded="true" aria-controls="taTpDropDown">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
            <span>Stock</span>
        </a>
        <div id="taTpDropDown_stock" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Stock Approval:</h6>

                <a class="collapse-item" href="{{ route('stock.admin_index') }}">List</a>

            </div>
        </div>


    </li>

    @endhasrole


    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
