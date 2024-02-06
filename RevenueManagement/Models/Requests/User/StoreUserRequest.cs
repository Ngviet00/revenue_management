using System.ComponentModel.DataAnnotations;

namespace RevenueManagement.Models.Requests.User
{
    public class StoreUserRequest
    {
        public string? Name { get; set; }

        [Required(ErrorMessage = "Tên đăng nhập không được để trống!")]
        public string Username { get; set; } = string.Empty;

        [Required(ErrorMessage = "Mật khẩu không được để trống!")]
        [MinLength(6, ErrorMessage = "Mật khẩu phải có ít nhất 6 ký tự!")]
        public string Password { get; set; } = string.Empty;
        
        public string? Phone { get; set; }
        
        public string? Email { get; set; }
        
        public string? Image { get; set; }
        
        public int? Sex { get; set; }
        
        public DateOnly? DateOfBirth { get; set; }
        
        public int RoleId { get; set; }
    }
}
