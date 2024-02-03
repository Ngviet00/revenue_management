using System.ComponentModel.DataAnnotations;

namespace RevenueManagement.Models.Requests.Auth
{
    public class LoginRequest
    {
        [Required(ErrorMessage = "Tên người dùng không được để trống!")]
        public string Username { get; set; } = string.Empty;

        [Required(ErrorMessage = "Mật khẩu không được để trống!")]
        public string Password { get; set; } = string.Empty;
    }
}
