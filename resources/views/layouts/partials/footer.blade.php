<footer class="main-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <div class="logo">
                    <i class="fas fa-book"></i>
                    <span>Hiên Sách</span>
                </div>
                <p>Khám phá thế giới tri thức với hàng ngàn đầu sách đa dạng thể loại.</p>
            </div>
            
            <div class="footer-section">
                <h3>Liên kết nhanh</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ route('books.index') }}">Danh mục sách</a></li>
                    <li><a href="#">Sách bán chạy</a></li>
                    <li><a href="#">Sách mới</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Hỗ trợ</h3>
                <ul>
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                    <li><a href="#">Chính sách vận chuyển</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Liên hệ</h3>
                <p><i class="fas fa-map-marker-alt"></i> 227 Nguyễn Văn Cừ, Quận 5, TP.HCM</p>
                <p><i class="fas fa-phone"></i> 1900 9999</p>
                <p><i class="fas fa-envelope"></i> support@bookstore.vn</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} BookStore. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</footer>